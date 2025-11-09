<?php
/* response3.php — Omacha-Shop knowledge (payments/address + payment-problem triage + instructional how-to) */
function kb_response3() {
  return [
    // ---- Payments & Address (reference) ----
    [
      'id' => 'payments_001',
      'titles' => ['payment methods','pay options','cod','gcash','card payment','card declined'],
      'answer' => "We accept COD, GCash, and major debit/credit cards. For card errors, enable online purchases and ensure your billing address matches your bank."
    ],
    [
      'id' => 'payment_problem_triage',
      'titles' => ['payment problem','payment failed','cannot pay','payment not going through','cod not available','gcash failed','card declined'],
      'answer' => "Try another method (COD/e-wallet/card) and ensure your card supports online purchases. Check balance and matching billing address. If COD isn’t shown, it isn’t available for that order/address. Clear app cache or update, then retry. If it still fails, contact your bank/e-wallet and share the error code with support."
    ],
    [
      'id' => 'address_001',
      'titles' => ['change address','edit address','wrong address','update address'],
      'answer' => "Me → Addresses → Add New or Edit. Changes apply to new orders only. For an existing order, contact support before the seller ships."
    ],

    // ---- New instructional entries ----
    [
      'id' => 'apply_shop_voucher',
      'titles' => ['apply shop voucher','use shop voucher','shop voucher','how to use shop voucher'],
      'answer' => "Apply a shop voucher: at Checkout under the shop section → Vouchers → select a shop voucher that meets min spend → Apply. The discount shows in the fee breakdown."
    ],
    [
      'id' => 'apply_platform_voucher',
      'titles' => ['apply platform voucher','use platform voucher','platform voucher','how to use platform voucher'],
      'answer' => "Apply a platform voucher: Checkout → Platform Vouchers/Coins → pick the best voucher → Apply. Some vouchers only work on selected items/shops."
    ],
    [
      'id' => 'use_coins',
      'titles' => ['use coins','apply coins','coins discount','how to use coins'],
      'answer' => "Use coins: Checkout → Platform Vouchers/Coins → toggle Coins to reduce your total. Coins may have caps/expiry—see Coin History in your profile."
    ],
    [
      'id' => 'pay_with_gcash',
      'titles' => ['pay with gcash','gcash payment','gcash checkout','how to pay gcash'],
      'answer' => "Pay with GCash: Payment Methods → Add GCash or choose GCash at checkout → log in to GCash → confirm. Make sure your GCash is verified and has enough balance."
    ],
    [
      'id' => 'enable_cod',
      'titles' => ['enable cod','turn on cod','why cod not available','cod option missing'],
      'answer' => "COD appears only for eligible items, addresses, and amounts. Try a different courier, reduce cart value, or use a nearby address. If COD isn’t shown at checkout, it’s not available for that order."
    ],
    [
      'id' => 'add_payment_method',
      'titles' => ['add payment method','save card','add card','add e wallet','add payment'],
      'answer' => "Add a payment method: Me → Payment Methods → Add Card/E-wallet → enter details → verify if required. You can remove or set default later in the same menu."
    ],
    [
      'id' => 'get_invoice',
      'titles' => ['official receipt','invoice','download receipt','get invoice'],
      'answer' => "Get your invoice/receipt: Me → Orders → select order → Details → Receipt/Invoice → Download or Email. Keep it for warranty and reimbursement."
    ],
  ];
}
