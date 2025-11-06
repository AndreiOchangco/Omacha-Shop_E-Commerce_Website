<?php
/**
 * Omacha-Shop — exception.php
 * Normalization + fuzzy matching helpers so the bot still understands:
 * - Wrong spelling / typos
 * - Random capitalizations
 * - Extra punctuation/spaces/emojis
 * - Repeated letters (“helloooo”)
 * - Slang/Taglish basics (pls/plz, tnx/thx, u/ur, etc.)
 *
 * Public helpers:
 *   normalize_text(string $s): string
 *   best_match(string $message, array $patterns, float $threshold=0.45): ?string
 *
 * Notes:
 * - best_match() accepts an array of trigger strings. Each trigger may contain
 *   alternatives separated by | (e.g., "hello|hi|hey"). It returns the trigger
 *   string that best matches the message, or null if below threshold.
 */

/* ---------------------------- NORMALIZATION ---------------------------- */

if (!function_exists('normalize_text')) {
  /**
   * Normalize user text: lower-case, strip diacritics, collapse whitespace,
   * reduce character spam, fix common typos/slang, and keep only useful chars.
   */
  function normalize_text(string $s): string {
    // Convert fancy quotes/emoji/punctuation to plain space
    $s = preg_replace('/[\x{1F300}-\x{1FAFF}\x{1F000}-\x{1F6FF}]/u', ' ', $s); // emojis
    $s = str_replace(["\u{2018}","\u{2019}","\u{201C}","\u{201D}"], ["'","'","\"","\""], $s);

    // Transliterate to ASCII where possible (remove accents)
    $t = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
    if ($t !== false) $s = $t;

    // Lowercase
    $s = strtolower($s);

    // Replace common chat slang / Taglish
    $slang = [
      'pls' => 'please', 'plz' => 'please',
      'tnx' => 'thanks', 'thx' => 'thanks', 'ty' => 'thanks',
      'u' => 'you', 'ur' => 'your', 'ya' => 'you',
      'imo' => 'in my opinion', 'btw' => 'by the way',
      'asap' => 'as soon as possible',
      'idk' => 'i dont know', 'omg' => 'oh my god',
      'anu' => 'what', 'ano' => 'what', 'pls po' => 'please',
      'opo' => 'yes', 'oo' => 'yes', 'hndi' => 'no', 'hindi' => 'no',
    ];
    $s = ' ' . $s . ' ';
    foreach ($slang as $k => $v) {
      $s = preg_replace('/\b'.preg_quote($k, '/').'\b/u', $v, $s);
    }
    $s = trim($s);

    // Fix frequent typos (non-exhaustive)
    $typos = [
      'recieve' => 'receive', 'adress' => 'address', 'addres' => 'address',
      'oder' => 'order', 'prdct' => 'product', 'vaucher' => 'voucher',
      'verfication' => 'verification', 'verfication' => 'verification',
      'pasword' => 'password', 'loggin' => 'login', 'otp codee' => 'otp code',
      'traking' => 'tracking', 'delievery' => 'delivery',
    ];
    foreach ($typos as $k => $v) {
      $s = preg_replace('/\b'.preg_quote($k, '/').'\b/u', $v, $s);
    }

    // Convert "5days" -> "5 days"
    $s = preg_replace('/(\d)([a-z]+)/i', '$1 $2', $s);

    // Keep math symbols helpful for calculator
    $allowedPunct = '+\-*/%^()';
    $s = preg_replace('/[^a-z0-9\s'.preg_quote($allowedPunct,'/').']/u', ' ', $s);

    // Reduce letter spam: "helloooo" -> "helloo" (keep up to 2)
    $s = preg_replace('/(.)\1{2,}/u', '$1$1', $s);

    // Collapse whitespace
    $s = preg_replace('/\s+/u', ' ', trim($s));

    return $s;
  }
}

/* --------------------------- FUZZY MATCHING ---------------------------- */

if (!function_exists('dice_coefficient')) {
  /**
   * Sorensen–Dice coefficient over character bigrams.
   */
  function dice_coefficient(string $a, string $b): float {
    $a = normalize_text($a);
    $b = normalize_text($b);
    $A = [];
    for ($i=0; $i < strlen($a)-1; $i++) {
      $g = $a[$i].$a[$i+1];
      if (trim($g) !== '') $A[$g] = ($A[$g] ?? 0) + 1;
    }
    $B = [];
    for ($i=0; $i < strlen($b)-1; $i++) {
      $g = $b[$i].$b[$i+1];
      if (trim($g) !== '') $B[$g] = ($B[$g] ?? 0) + 1;
    }
    $na = array_sum($A); $nb = array_sum($B);
    if ($na === 0 || $nb === 0) return 0.0;

    $inter = 0;
    foreach ($A as $g => $c) {
      if (!empty($B[$g])) {
        $m = min($c, $B[$g]);
        $inter += $m;
      }
    }
    return (2.0 * $inter) / ($na + $nb);
  }
}

if (!function_exists('lev_sim')) {
  /**
   * Normalized Levenshtein similarity (0..1).
   */
  function lev_sim(string $a, string $b): float {
    $a = normalize_text($a);
    $b = normalize_text($b);
    if ($a === $b) return 1.0;
    $len = max(strlen($a), strlen($b));
    if ($len === 0) return 0.0;
    $dist = levenshtein($a, $b);
    return 1.0 - ($dist / $len);
  }
}

if (!function_exists('alt_tokens')) {
  /**
   * Split a trigger string into alternatives: "hello|hi|hey" -> ["hello","hi","hey"]
   */
  function alt_tokens(string $pattern): array {
    $parts = preg_split('/\|/u', $pattern);
    $out = [];
    foreach ($parts as $p) {
      $p = trim($p);
      if ($p!=='') $out[] = $p;
    }
    return $out;
  }
}

if (!function_exists('regex_hit')) {
  /**
   * True if message contains any of the alternatives as a word-ish match.
   */
  function regex_hit(string $message, array $alts): bool {
    $message = ' '.normalize_text($message).' ';
    foreach ($alts as $a) {
      $a = preg_quote(normalize_text($a), '/');
      if (preg_match('/(^|\s)'.$a.'(\s|$)/u', $message)) return true;
    }
    return false;
  }
}

if (!function_exists('score_against_pattern')) {
  /**
   * Score message against a trigger pattern (with | alts).
   * Returns max of dice/lev over all alts with a small regex bonus.
   */
  function score_against_pattern(string $message, string $pattern): float {
    $alts = alt_tokens($pattern);
    $best = 0.0;
    foreach ($alts as $a) {
      $d = dice_coefficient($message, $a);
      $l = lev_sim($message, $a);
      $s = max($d, $l);
      if ($s > $best) $best = $s;
    }
    if (regex_hit($message, $alts)) $best = max($best, 0.75); // regex “word” bonus
    return $best;
  }
}

if (!function_exists('best_match')) {
  /**
   * Pick the best-matching trigger from an array of patterns.
   * Each pattern may contain "|" to denote alternatives.
   *
   * @param string $message
   * @param array  $patterns
   * @param float  $threshold  minimum similarity to accept (0..1)
   * @return ?string the winning pattern (original string) or null
   */
  function best_match(string $message, array $patterns, float $threshold=0.45): ?string {
    $best = null; $bestScore = -1.0;
    foreach ($patterns as $p) {
      if (!is_string($p) || $p==='') continue;
      $score = score_against_pattern($message, $p);
      if ($score > $bestScore) {
        $bestScore = $score;
        $best = $p;
      }
    }
    return ($best !== null && $bestScore >= $threshold) ? $best : null;
  }
}

/* -------------------------- EXTRA UTILITIES ---------------------------- */

if (!function_exists('extract_basic_entities')) {
  /**
   * Extract very basic entities (order id, email/phone) from text.
   * Not used for storage; helps future intent modules.
   */
  function extract_basic_entities(string $text): array {
    $out = [];
    if (preg_match('/\b(order|ord|oid)[\s#:]*([A-Z0-9\-]{6,})\b/i', $text, $m)) {
      $out['order_id'] = $m[2];
    }
    if (preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i', $text, $m)) {
      $out['email'] = $m[0];
    }
    if (preg_match('/\b(\+?63|0)9\d{9}\b/', $text, $m)) {
      $out['phone'] = $m[0];
    }
    return $out;
  }
}
