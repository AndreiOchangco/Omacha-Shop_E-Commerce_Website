<?php
/**
 * omacha Customer Care — System Prompt
 * Role
 *   You are omacha’s customer-support chatbot. Answer precisely, briefly, and only from the provided Knowledge entries.
 *
 * Behavior
 *   - Understand typos, slang, and Taglish; rewrite answers clearly.
 *   - If the user mixes greeting + request, give a short greeting (2–5 words) then answer immediately.
 *   - If the user asks multiple things, pick ONE primary intent; if needed, ask ONE short clarifying question, then give steps.
 *   - Extract useful details (order_id, email/phone, item, date, payment method, address) and use them when relevant.
 *   - If no relevant Knowledge exists, say so and give the next step (Help Center/contact).
 *   - Never invent policy, dates, fees, or tracking info not in Knowledge.
 *   - Keep replies compact: 3–6 short steps/sentences max.
 *
 * Answer Format
 *   - Start with a micro-acknowledgment if greeted (e.g., “Hi!” or “Sure!”).
 *   - Then give the answer in numbered steps or crisp sentences.
 *   - End with one helpful follow-up offer (e.g., “Want the tracking link?”).
 *
 * Safety & Scope
 *   - Don’t request/store full card numbers or passwords.
 *   - If a question is outside omacha, say it’s out of scope and suggest contacting support.
 *
 * Conflict Resolution
 *   - If Knowledge conflicts, prefer the newest entry.
 *
 * Output
 *   - Provide the final answer only. If you must clarify, ask one short question and still give the most likely next step.
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

require_once __DIR__ . '/../exception/exception.php';
require_once __DIR__ . '/response1.php';      // greetings + how-to + login/OTP/account
require_once __DIR__ . '/response2.php';      // orders/returns + triage + catalog
require_once __DIR__ . '/response3.php';      // payments/address + triage
require_once __DIR__ . '/other_response.php'; // hours/contact/misc + symbols + troubleshooting

// ---- Read q from POST/GET/JSON ----
$q = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['q'])) {
        $q = $_POST['q'];
    } else {
        $raw = file_get_contents('php://input');
        $j = json_decode($raw, true);
        if (isset($j['q'])) $q = $j['q'];
    }
} else {
    $q = $_GET['q'] ?? '';
}
$q = trim((string)$q);

if ($q === '') {
    echo json_encode([
        'reply' => "Tell me what you need help with—login/OTP, tracking an order, returns/refunds, payments, or address changes.",
        'quick' => ['Hello','Order problem help','Track order','Return/Refund','Payment problem','Change address','Support hours','Contact support','Calculator']
    ]);
    exit;
}

/* ---------------- Utilities ---------------- */
function normalize_ascii($s) {
    $s = mb_convert_encoding($s, 'UTF-8', 'UTF-8');
    if (function_exists('normalize_text')) $s = normalize_text($s); // from exception.php
    $s = mb_strtolower($s, 'UTF-8');
    $s = preg_replace('/[^a-z0-9\%\+\-\*\/\^\(\)\s]/u', ' ', $s); // keep math symbols too
    $s = preg_replace('/\s+/', ' ', trim($s));
    return $s;
}
function bigrams_php($s) {
    $t = normalize_ascii($s);
    $out = [];
    $len = strlen($t);
    for ($i=0; $i < $len-1; $i++) {
        $g = $t[$i] . $t[$i+1];
        if (trim($g) !== '' && strlen(trim($g))===2) $out[] = $g;
    }
    return $out;
}
function dice_sim($a, $b) {
    $A = bigrams_php($a);
    $B = bigrams_php($b);
    $na = count($A); $nb = count($B);
    if ($na === 0 || $nb === 0) return 0.0;
    $map = [];
    foreach ($B as $g) { $map[$g] = ($map[$g] ?? 0) + 1; }
    $inter = 0;
    foreach ($A as $g) { if (!empty($map[$g])) { $inter++; $map[$g]--; } }
    return (2.0 * $inter) / ($na + $nb);
}
function score_doc($q, $doc) {
    $best = 0.0;
    if (!empty($doc['titles']) && is_array($doc['titles'])) {
        foreach ($doc['titles'] as $t) {
            $s1 = dice_sim($q, $t);
            if ($s1 > $best) $best = $s1;
        }
    }
    if (!empty($doc['answer'])) {
        $s2 = dice_sim($q, $doc['answer']);
        if ($s2 > $best) $best = $s2;
    }
    return $best;
}

/* ----------- Micro-ack de-dup (avoid “Sure! Welcome! Sure…”) ----------- */
function starts_with_ack($text) {
    $t = ltrim(normalize_ascii($text));
    return (bool)preg_match('/^(hi|hello|hey|welcome|sure|okay|ok|great|i can help|i can assist)\b/i', $t);
}
function strip_leading_ack($text) {
    $out = ltrim($text);
    $out = preg_replace('/^(?:(hi|hello|hey|welcome|sure|okay|ok|great)[\s!\.,-:]+)+/i', '', $out, 1);
    $out = preg_replace('/^(i\s+(can|will)\s+(help|assist)(\s+you)?[\s!\.,:-]+)+/i', '', $out, 1);
    return ltrim($out);
}

/* ---------------- Tiny calculator (safe-ish) ---------------- */
function text_to_math($q) {
    $s = normalize_ascii($q);
    $repl = [
        '/\b(plus|\+)\b/'                                => '+',
        '/\b(minus|\-)\b/'                               => '-',
        '/\b(times|x|multiply|multiplied by)\b/'         => '*',
        '/\b(divide|divided by|over)\b/'                 => '/',
        '/\b(mod|modulo)\b/'                             => '%',
        '/\b(power of|to the power of|raised to|\^)\b/'  => '**',
    ];
    foreach ($repl as $rx=>$op) $s = preg_replace($rx, " $op ", $s);

    // "A percent of B" => (A/100)*B
    $s = preg_replace_callback('/(\d+(?:\.\d+)?)\s*%(\s*of\s*)?(\d+(?:\.\d+)?)/', function($m){
        $a=$m[1]; $b=$m[3]; return "(($a/100)*$b)";
    }, $s);

    // Standalone %
    $s = preg_replace('/(\d+(?:\.\d+)?)\s*%/', '($1/100)', $s);

    // Keep only math tokens
    $expr = preg_replace('/[^0-9\.\+\-\*\/\%\(\)\s]/', ' ', $s);
    $expr = preg_replace('/\s+/', ' ', trim($expr));

    if (!preg_match('/\d/', $expr) || !preg_match('/[\+\-\*\/\%]/', $expr)) return null;
    if (!preg_match('/^[0-9\.\+\-\*\/\%\(\)\s]+$/', str_replace('**','^',$expr))) return null;

    return $expr;
}
function eval_math($expr) {
    set_error_handler(function(){});
    try { $result = @eval('return ('.$expr.');'); } catch (Throwable $e) { $result = null; }
    restore_error_handler();
    if ($result === null || $result === false) return null;
    if (is_float($result)) $result = rtrim(rtrim(number_format($result, 6, '.', ''), '0'), '.');
    return (string)$result;
}

/* ---------------- Load & de-dup Knowledge ---------------- */
$kb = array_merge(
    kb_response1(),
    kb_response2(),
    kb_response3(),
    kb_other_response()
);
$dedup = [];
foreach ($kb as $doc) {
    $id = $doc['id'] ?? uniqid('doc_', true);
    $dedup[$id] = $doc; // last write wins (newest)
}
$kb = array_values($dedup);

/* ---------------- Out-of-scope platforms guard ---------------- */
$normQ = normalize_ascii($q);
if (preg_match('/\b(shopee|tik\s*tok\s*shop|tiktok\s*shop|lazada|amazon|zalora|ebay)\b/i', $normQ) && !preg_match('/\bomacha\b/i', $normQ)) {
    $how = null;
    foreach ($kb as $d) if (($d['id'] ?? '') === 'how_to_order') { $how = $d['answer']; break; }
    $fallback = $how ?: "On omacha: 1) Open a product and choose variation/quantity. 2) Add to Cart/Buy Now. 3) Confirm address & shipping. 4) Pick payment. 5) Place Order.";
    echo json_encode([
        'reply' => "That’s outside omacha’s scope. For omacha orders: $fallback Want help with tracking here?",
        'quick' => ['How to order','Track order','Return/Refund','Payment methods','Change address','Support hours','Contact support']
    ]);
    exit;
}

/* ---------------- Calculator fast-path ---------------- */
$expr = text_to_math($q);
if ($expr !== null) {
    $ans = eval_math($expr);
    if ($ans !== null) {
        echo json_encode([
            'reply' => "Result: $ans",
            'quick' => ['New calculation','Calculator','How to order','Track order','Return/Refund','Payment methods']
        ]);
        exit;
    }
}

/* ---------------- Helpers: greeting/affirmation/negation ---------------- */
function has_greeting($q) {
    return (bool)preg_match('/\b(hello|hi|hey|good\s*(morning|afternoon|evening)|kumusta|kamusta)\b/i', $q);
}
function wants_help($q) {
    return (bool)preg_match('/\b(help|assist|how to|paano|track|order|return|refund|payment|pay|address|login|otp)\b/i', $q);
}
function is_yes($q){ return (bool)preg_match('/\b(yes|yep|yeah|yup|sure|ok|okay|opo|oo|sige|please|go ahead)\b/i',$q); }
function is_no($q){  return (bool)preg_match('/\b(no|nope|not now|hindi|wag|later|maybe later)\b/i',$q); }

/* ---------------- Follow-up mapping ---------------- */
function followup_payload($id) {
    $map = [
        'how_to_order'               => ['question'=>'Need the tracking steps after purchase?','awaiting'=>'offer_tracking','next_id'=>'order_status_001'],
        'login_001'                  => ['question'=>'Want steps to update your number?','awaiting'=>'update_number','next_id'=>'update_number_steps'],
        'order_status_001'           => ['question'=>'Want the contact steps?','awaiting'=>'contact_steps','next_id'=>'contact_001'],
        'returns_001'                => ['question'=>'Need help choosing the return reason?','awaiting'=>'reason_tips','next_id'=>'returns_reason_tips'],
        'payments_001'               => ['question'=>'Want common card error fixes?','awaiting'=>'card_fixes','next_id'=>'card_error_fixes'],
        'payment_problem_triage'     => ['question'=>'Want a checklist for bank/e-wallet issues?','awaiting'=>'card_fixes','next_id'=>'card_error_fixes'],
        'address_001'                => ['question'=>'Do you want steps to edit your address now?','awaiting'=>'edit_address','next_id'=>'address_001'],
        'order_problem_triage'       => ['question'=>'Do you want me to open the Return/Refund steps?','awaiting'=>'open_return','next_id'=>'returns_001'],
        'product_catalog_001'        => ['question'=>'Want me to narrow by category and budget?','awaiting'=>'narrow_catalog','next_id'=>null],
        'product_availability_check' => ['question'=>'Share the exact item and budget so I can suggest options?','awaiting'=>'narrow_catalog','next_id'=>null],
    ];
    return $map[$id] ?? null;
}

/* ---------------- Resolve a doc by id ---------------- */
function doc_by_id($kb, $id) {
    foreach ($kb as $d) if (($d['id'] ?? '') === $id) return $d;
    return null;
}

/* ---------------- Handle YES/NO to previous follow-up ---------------- */
if (isset($_SESSION['awaiting']) && $_SESSION['awaiting']) {
    if (is_no($q)) {
        $_SESSION['awaiting'] = null;
        echo json_encode(['reply'=>"No problem. Anything else I can help with?",'quick'=>['How to order','Track order','Return/Refund','Payment methods','Change address','Support hours','Contact support','Calculator']]);
        exit;
    }
    if (is_yes($q)) {
        $await = $_SESSION['awaiting'];
        $_SESSION['awaiting'] = null;

        if ($await === 'offer_tracking') {
            $doc = doc_by_id($kb,'order_status_001');
            $reply = $doc ? $doc['answer'] : "Me → Orders → select the order → Track.";
            echo json_encode(['reply'=>$reply,'quick'=>['Track order','Contact support','Return/Refund','Payment methods','How to order']]);
            exit;
        }
        if ($await === 'update_number') {
            $doc = doc_by_id($kb,'update_number_steps');
            $reply = $doc ? $doc['answer'] : "Me → Settings → Account → Phone → Edit → Verify with code.";
            echo json_encode(['reply'=>$reply,'quick'=>['Login help','Change address','Contact support']]);
            exit;
        }
        if ($await === 'contact_steps') {
            $doc = doc_by_id($kb,'contact_001');
            echo json_encode(['reply'=>$doc ? $doc['answer'] : 'Open Help Center → Contact Support.','quick'=>['Support hours','Track order','Return/Refund']]);
            exit;
        }
        if ($await === 'card_fixes') {
            $doc = doc_by_id($kb,'card_error_fixes');
            echo json_encode(['reply'=>$doc ? $doc['answer'] : 'Check balance, enable online purchases, and match billing address.','quick'=>['Payment methods','Contact support']]);
            exit;
        }
        if ($await === 'open_return') {
            $doc = doc_by_id($kb,'returns_001');
            echo json_encode(['reply'=>$doc ? $doc['answer'] : 'Me → Orders → Return/Refund.','quick'=>['Order problem help','Contact support']]);
            exit;
        }
        if ($await === 'reason_tips') {
            $doc = doc_by_id($kb,'returns_reason_tips');
            echo json_encode(['reply'=>$doc ? $doc['answer'] : 'Choose the closest reason: Wrong item/variant, Damaged/Defective, Missing/Incomplete, or Not received (late beyond ETA). Upload clear photos/video and the shipping label.','quick'=>['Return/Refund','Track order']]);
            exit;
        }
        if ($await === 'edit_address') {
            $doc = doc_by_id($kb,'address_001');
            echo json_encode(['reply'=>$doc ? $doc['answer'] : 'Me → Addresses → Add New or Edit (applies to new orders).','quick'=>['Change address','Payment methods']]);
            exit;
        }
        if ($await === 'narrow_catalog') {
            $_SESSION['awaiting'] = 'narrow_catalog_details';
            $reply = "Great! Tell me the category and budget (e.g., “headphones under ₱1000” or “baby toys below 500”). I’ll show exact steps to filter.";
            echo json_encode(['reply'=>$reply,'quick'=>['Electronics under 2000','Phone accessories under 300','Toys under 500']]);
            exit;
        }
        if ($await === 'offer_voucher_help') {
            $doc = doc_by_id($kb,'apply_shop_voucher');
            $reply = ($doc ? $doc['answer'] : "At Checkout → under shop → Vouchers → select and Apply.");
            echo json_encode(['reply'=>$reply,'quick'=>['Apply platform voucher','Use coins','Payment methods']]);
            exit;
        }
    }

    if ($_SESSION['awaiting'] === 'narrow_catalog_details') {
        $text = normalize_ascii($q);
        $category = null;
        $cats = [
            'electronics' => ['electronics','gadget','phone','earbuds','headphone','computer','laptop','camera'],
            'accessories' => ['accessories','cable','charger','case'],
            'home'        => ['home','kitchen','living','bed','bath'],
            'fashion'     => ['fashion','clothes','apparel','shirt','pants','dress','shoes'],
            'beauty'      => ['beauty','skin','makeup','cosmetic','personal care'],
            'groceries'   => ['grocery','groceries','food','snack','beverage'],
            'pet'         => ['pet','dog','cat','pet care'],
            'sports'      => ['sport','sports','outdoor','fitness','gym'],
            'toys'        => ['toy','toys','baby','kids'],
            'auto'        => ['auto','car','motor','moto'],
        ];
        foreach ($cats as $label=>$kwds) {
            foreach ($kwds as $k) { if (preg_match('/\b'.preg_quote($k,'/').'\b/i',$text)) { $category = ucfirst($label); break 2; } }
        }
        $budget = null;
        if (preg_match('/(?:₱|php|php\s*)?(\d{2,6}(?:[\.,]\d{2})?)/i',$q,$m)) {
            $budget = preg_replace('/[^\d\.]/','',$m[1]);
        }
        $_SESSION['awaiting'] = 'offer_voucher_help';

        $catPart = $category ? "category: $category; " : "";
        $budPart = $budget ? "budget: ₱".number_format((float)$budget,0,'.',',')."; " : "";
        $reply = "Got it — {$catPart}{$budPart}here’s how to narrow results: 1) Use Search with your keywords. 2) Tap Filters → choose Category, set Price ".($budget?'max to your budget':'range as needed').", and toggle In-stock/COD if you like. 3) Sort by Rating or Price. Want voucher tips at checkout?";
        echo json_encode(['reply'=>$reply,'quick'=>['Apply shop voucher','Apply platform voucher','Use coins']]);
        exit;
    }
}

/* ---------------- Primary-intent selection ---------------- */
$threshold = 0.60;
$best = null; $bestScore = -1.0;
foreach ($kb as $doc) {
    $s = score_doc($q, $doc);
    if ($s > $bestScore) { $bestScore = $s; $best = $doc; }
}

if (!$best || $bestScore < $threshold) {
    $reply = "I don’t have that info in my Knowledge. Please use Help Center → Contact Support, or tell me if this is about login/OTP, order status, returns/refunds, payments, or address changes.";
    $_SESSION['awaiting'] = null;
} else {
    $answer = $best['answer'];

    $ack = '';
    if (has_greeting($q)) {
        $ackCandidate = wants_help($q) ? "Sure! " : "Hi! ";
        if (!starts_with_ack($answer)) $ack = $ackCandidate;
        else $answer = strip_leading_ack($answer);
    }

    if (function_exists('extract_basic_entities')) {
        $ent = extract_basic_entities($q);
        if (!empty($ent['order_id']) && in_array($best['id'], ['order_status_001','order_problem_triage','delivery_late_or_stuck'])) {
            $answer = "Order ID: {$ent['order_id']}. " . $answer;
        }
    }

    $follow = followup_payload($best['id'] ?? '');
    if ($follow) {
        $_SESSION['awaiting'] = $follow['awaiting'];
        $tail = ' '.$follow['question'];
    } else {
        $_SESSION['awaiting'] = null;
        $tail = '';
    }

    if (preg_match('/\b(and|also|plus|,)\b/i', $q)) {
        $tail .= " If you also need help with another topic, tell me which one and I’ll send the steps.";
    }

    $reply = $ack . $answer . $tail;
}

if (preg_match('/(card|payment|otp|password|identity|id)/i', $q)) {
    $reply .= " Never share full card numbers, passwords, or OTPs in chat.";
}

echo json_encode([
    'reply' => $reply,
    'quick' => ['Hello','How to order','Track order','Return/Refund','Payment methods','Change address','Support hours','Contact support','Calculator']
]);
