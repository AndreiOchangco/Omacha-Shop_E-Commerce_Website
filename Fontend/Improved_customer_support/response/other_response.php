<?php
/* other_response.php — Omacha-Shop misc knowledge, hours/contact, general troubleshooting, calculator tips, symbols guide + instructional extras */
function kb_other_response() {
  return [
    [
      'id' => 'hours_001',
      'titles' => ['hours','open time','support time','customer service hours','what time are you open'],
      'answer' => "Support is available daily, 9:00–18:00 PH time."
    ],
    [
      'id' => 'contact_001',
      'titles' => ['contact support','talk to agent','help center','human agent','email support'],
      'answer' => "Open the app → Help Center → Contact Support, or email support@omacha-shop.example with your order ID and phone number."
    ],
    [
      'id' => 'shop_info_overview',
      'titles' => ['about your shop','about omacha-shop','what is omacha-shop','who is omacha-shop','company info','shop info','store info'],
      'answer' => "Omacha-Shop is a retail shop serving customers in the Philippines. Our business location is **San Fernando, La Union (PH)**. For support, chat here or go to Help Center → Contact Support."
    ],
    [
      'id' => 'shop_policies_overview',
      'titles' => ['policies','shop policies','store rules','rules','terms','guidelines'],
      'answer' => "Policy highlights: 1) Orders—review item details, shipping fees, and ETA before placing. 2) Payments—COD, GCash, or card; never share OTPs. 3) Shipping—ETA shown at checkout; track in Me → Orders. 4) Returns/Refunds—start from the order page with photos/video; keep packaging. 5) Privacy—use official channels only; we never ask for full card numbers or passwords. See Help Center for full terms."
    ],
    [
      'id' => 'return_policy_summary',
      'titles' => ['return policy','refund policy','replacement policy','how long to return','return rules'],
      'answer' => "Return/Refund: Me → Orders → select order → Return/Refund → choose reason (wrong/damaged/missing/non-delivery) → upload photos/video → Submit. Keep packaging while the case is reviewed. Eligibility follows rules shown on the order page."
    ],
    [
      'id' => 'shipping_policy_summary',
      'titles' => ['shipping policy','delivery policy','shipping rules','delivery rules'],
      'answer' => "Fees and ETA depend on address/courier and are shown on the product and checkout pages. Track via Me → Orders → Track. If there’s no scan for 48h, contact support and extend Buyer Protection from the order page."
    ],
    [
      'id' => 'payment_policy_summary',
      'titles' => ['payment policy','cod policy','gcash policy','card policy','payment rules'],
      'answer' => "Accepted methods: COD, GCash, major cards. Orders may be canceled if payment is incomplete or fails verification. Card billing address must match your bank. Never share OTPs or full card numbers."
    ],
    [
      'id' => 'privacy_policy_summary',
      'titles' => ['privacy policy','data privacy','security policy','safety policy'],
      'answer' => "We handle your data per applicable rules. We ask only what’s needed to process orders and support you. Don’t share passwords or OTPs in chat; report suspicious messages via Help Center."
    ],
    [
      'id' => 'cancellation_policy_summary',
      'titles' => ['cancellation policy','cancel policy','order cancellation rules'],
      'answer' => "If not shipped: Me → Orders → the order → Cancel. After shipping, use Return/Refund options. Vouchers/coins may not be restored after cancellation depending on checkout terms."
    ],

    [
      'id' => 'general_troubleshooting',
      'titles' => ['problem with app','bug','error','app not working','system problem','something wrong'],
      'answer' => "Update the app, clear cache, and try another network. If the issue remains, take a screenshot or screen recording and send it via Help Center → Contact Support with your device model and app version."
    ],

    // ---- Calculator knowledge ----
    [
      'id' => 'calc_001',
      'titles' => ['calculator','calculate','compute','what is','percent','percentage','sum','difference','product','quotient','add','minus','times','divide'],
      'answer' => "You can send math like “12*3”, “(250 + 75) / 2”, or “20% of 1499”. I’ll compute it and show the result."
    ],
    [
      'id' => 'calc_now',
      'titles' => [
        'compute this','compute now','solve this','evaluate','answer','what is the result',
        'total after discount','discount percent','increase by percent','decrease by percent',
        'sum of','difference of','product of','quotient of'
      ],
      'answer' => "Type your expression plainly (e.g., “1499 - 20% of 1499”, “3 * (8 + 2)”, “2^5”). I’ll reply with the result."
    ],

    /* ---------- Symbols & punctuation meaning (language) ---------- */
    [
      'id' => 'symbols_lang_001',
      'titles' => [
        'symbols','punctuation','special characters','what do symbols mean','use of symbols',
        'what does question mark mean','what does exclamation point mean','meaning of comma','meaning of period',
        'what does apostrophe mean','quotation marks meaning','parentheses meaning','brackets meaning','braces meaning',
        'colon meaning','semicolon meaning','dash meaning','hyphen meaning','ellipses meaning'
      ],
      'answer' => "Common punctuation: \n• ? question mark — asks a question.\n• ! exclamation — strong feeling or emphasis.\n• . period — ends a sentence.\n• , comma — short pause; separates items.\n• ' apostrophe — possession or contractions (don't, user's).\n• “ ” quotes — exact words/titles; ‘ ’ single quotes sometimes inside.\n• ( ) parentheses — side notes/extra info.\n• [ ] brackets and { } braces — grouping/technical notes.\n• : colon — introduces a list/explanation; ; semicolon — links related clauses.\n• - hyphen joins words; — dash adds a break/emphasis."
    ],

    /* ---------- Symbols & special characters (technical/typing) ---------- */
    [
      'id' => 'symbols_tech_001',
      'titles' => [
        'special symbols meaning','what does at sign mean','what does hashtag mean','what does ampersand mean',
        'what does percent sign mean','what does dollar sign mean','what does asterisk mean','what does slash mean',
        'what does backtick mean','what does caret mean','what does less than mean','what does greater than mean',
        'meaning of @ # $ % & * / ^ ` < >','symbol uses list','explain symbols'
      ],
      'answer' => "Common special characters: \n• @ at sign — emails (name@example.com).\n• # hash — tags/IDs (e.g., #order).\n• $ dollar — currency.\n• % percent — per-hundred (15% off).\n• & ampersand — means “and”.\n• * asterisk — multiply/wildcard/footnote.\n• / slash — fractions, paths (A/B).\n• ^ caret — exponent in math.\n• ` backtick — code formatting.\n• < > less/greater than — comparisons or HTML tags.\n• _ underscore — word separator in IDs.\n• 0–9 digits — numbers. Never share full card numbers or passwords."
    ],

    /* ---------- Extra instructional (general) ---------- */
    [
      'id' => 'update_app',
      'titles' => ['update app','how to update app','update to latest version'],
      'answer' => "Update the app: open Play Store/App Store → search “Omacha-Shop” → Update. Then reopen the app and try again."
    ],
    [
      'id' => 'clear_cache',
      'titles' => ['clear cache','how to clear cache','app cache'],
      'answer' => "Clear cache: in Omacha-Shop → Me → Settings → Clear Cache. On Android you can also use System Settings → Apps → Omacha-Shop → Storage → Clear cache."
    ],
    [
      'id' => 'report_seller_listing',
      'titles' => ['report seller','report listing','fake product','misleading listing','scam listing'],
      'answer' => "Report a listing: on the product page → ••• (More) → Report → pick the reason (fake/misleading) → add details and screenshots → Submit. We’ll review and take action if it violates policy."
    ],
  ];
}
