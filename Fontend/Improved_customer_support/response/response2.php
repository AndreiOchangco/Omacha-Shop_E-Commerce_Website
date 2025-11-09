<?php
/* response2.php — Omacha-Shop knowledge
   (orders/returns + order-problem triage + instructional how-to + product catalog & availability) */
function kb_response2() {
  return [
    // ---- Tracking & Returns (step-by-step) ----
    [
      'id' => 'order_status_001',
      'titles' => ['track order','where is my package','order status','shipping status','delivery date','track parcel'],
      'answer' => "Track your order: Me → Orders → select the order → Track. If the courier page shows no scan for 48 hours, contact support with your Order ID and registered phone."
    ],
    [
      'id' => 'returns_001',
      'titles' => ['return item','refund','replace item','wrong item','damaged item','return window'],
      'answer' => "Start a return/refund: Me → Orders → select order → Return/Refund → choose reason (wrong, damaged, missing) → upload photos/video → Submit. Keep original packaging until pickup."
    ],

    // ---- General order problem triage ----
    [
      'id' => 'order_problem_triage',
      'titles' => [
        'problem with my order','issue with my order','order problem','order help','order issue',
        'i have a problem with my order','something wrong with my order','need help with order'
      ],
      'answer' => "I can help. Please confirm your Order ID and item. Open Me → Orders → the order → Help/Return & Refund, then pick the exact issue (late, damaged, wrong, missing, not received) and upload clear photos/video and the shipping label. If tracking has no update for 48h past ETA, contact support and the courier. Buyer Protection keeps your money safe until it’s resolved."
    ],

    // ---- Late/no tracking ----
    [
      'id' => 'delivery_late_or_stuck',
      'titles' => ['late delivery','delivery delayed','tracking stuck','no update','not received yet','package late'],
      'answer' => "Open Me → Orders → Track. If there’s no scan for 48h, message the courier and contact support with your Order ID. Extend Buyer Protection from the order page. If it exceeds the extended ETA, file Return/Refund for non-delivery."
    ],

    // ---- Missing/short/partial items ----
    [
      'id' => 'missing_items',
      'titles' => ['missing item','incomplete items','short item','item not in the box','part missing'],
      'answer' => "Open the order → Return/Refund → “Missing/Incomplete”. Upload unboxing photos/video and the shipping label. Keep all packaging while the case is reviewed."
    ],

    // ---- Wrong/defective/damaged items ----
    [
      'id' => 'wrong_or_damaged',
      'titles' => ['wrong item','wrong variant','defective item','item not working','damaged on arrival','broken item'],
      'answer' => "Return/Refund → choose “Wrong item/Defective/Damaged” → add photos/video of the issue and the label → Submit. Choose Replacement or Refund. Don’t discard packaging until the claim completes."
    ],

    // ---- Cancel/edit before ship ----
    [
      'id' => 'cancel_or_edit_before_ship',
      'titles' => ['cancel my order','change my order','edit order','change variation after order','cancel order'],
      'answer' => "If not shipped: Me → Orders → the order → Cancel. For variant/address/payment changes, cancel and place a new order with correct details. After shipping, use Return/Refund options."
    ],

    // ---- Product catalog & availability (NEW) ----
    [
      'id' => 'product_catalog_001',
      'titles' => [
        'what are your available products','what are your availabel products','what are your avalable products',
        'available products','products available','product list','list of products','catalog','catalogue',
        'what do you sell','what items do you have','products you have','ano products nyo','anu products nyo',
        'ano mga produkto ninyo','meron kayo na products','do you have products','inventory'
      ],
      'answer' => "We carry a wide range of items: • Electronics & gadgets • Accessories • Home & living • Fashion & apparel • Beauty & personal care • Groceries & pet care • Sports & outdoors • Toys & baby • Auto & moto accessories. Browse via Home → Categories or use Search, then filter by price, rating, brand, or delivery speed."
    ],
    [
      'id' => 'product_availability_check',
      'titles' => [
        'do you have this','do you have','is this available','is it available','available ba','available po ba',
        'stock','in stock','is there stock','may stock','meron bang stock'
      ],
      'answer' => "To check availability, open the product page and select the variation (size/color/model). If Add to Cart/Buy Now is active, it’s in stock. You can also filter by “In stock” on search. Share the exact item name and your budget and I’ll help you narrow options."
    ],
    [
      'id' => 'product_find_specific',
      'titles' => [
        'find a product','find specific product','how to find product','search product','how to search',
        'paano maghanap ng product','how to find items'
      ],
      'answer' => "Use the Search bar with keywords or model numbers (e.g., “wireless earbuds ANC”). Refine with Filters → Price range, Brand, Rating, Location, Free shipping, COD. Sort by Best Match, Newest, or Price."
    ],
    [
      'id' => 'product_lowest_highest_price',
      'titles' => [
        'lowest price','cheapest item','what is your lowest price','highest price','most expensive',
        'what is your highest price'
      ],
      'answer' => "Set a budget using Filters → Price range to see the cheapest or premium options. Tell me the category and budget (e.g., “phone accessories under ₱300”) and I’ll suggest picks."
    ],
    [
      'id' => 'product_categories_follow',
      'titles' => [
        'how to browse categories','how to follow a shop','follow shop','find official stores','mall items'
      ],
      'answer' => "Go to Home → Categories to browse. On a shop page, tap Follow to get updates and vouchers. Look for Official Store/Omacha-Shop Mall badges for verified brands."
    ],
    [
      'id' => 'product_shipping_preview',
      'titles' => [
        'see shipping fee per item','shipping fee per item','estimated delivery before checkout',
        'eta before checkout','delivery date before checkout'
      ],
      'answer' => "On the product page, tap Shipping Info and enter your address to preview shipping fees and estimated delivery date before buying."
    ],
    [
      'id' => 'product_review_photos_specs',
      'titles' => [
        'see real buyer photos','review photos','full specs','specifications','dimensions','size chart'
      ],
      'answer' => "Open Reviews → filter by With Photos to see buyer images. Specs/Dimensions and Size Guide are in the product Description. If unsure, message the seller with your exact model/size."
    ],
  ];
}
