<?php
/* response1.php — omacha knowledge
   (greetings/small talk + compliments + how-to + login/OTP/account + new-user onboarding
    + proactive generic help/clarification responses) */
function kb_response1() {
  return [
    // ---- Greetings / basic conversation ----
    [
      'id' => 'greet_hello',
      'titles' => ['hello','hi','hey','good morning','good afternoon','good evening','yo','sup','kumusta','kamusta','good day'],
      'answer' => "Hi! I’m Omacha-Shop Customer Care. How can I help you today?"
    ],
    [
      'id' => 'greet_howareyou',
      'titles' => ['how are you','kumusta ka','kamusta ka','what’s up','whats up'],
      'answer' => "I’m doing great and ready to help. What do you need—login, orders, returns, payments, or address changes?"
    ],
    [
      'id' => 'greet_thanks',
      'titles' => ['thanks','thank you','salamat','ty','appreciate it','ok thanks','okay thanks','thanks a lot'],
      'answer' => "You’re welcome! Anything else I can help you with?"
    ],
    [
      'id' => 'greet_ack',
      'titles' => ['ok','okay','got it','noted','copy','sige','ayos'],
      'answer' => "Great! If you need anything—tracking, returns, payments, or address changes—just tell me."
    ],

    // ---- Compliments / positive feedback ----
    [
      'id' => 'compliment_001',
      'titles' => [
        'compliment','complement','great job','good job','nice job','awesome',
        'amazing','you are great','you re great','you are helpful','you re helpful',
        'you are the best','you re the best','nice one','great service','good service',
        'ang galing mo','galing','wow','super helpful','very helpful'
      ],
      'answer' => "Thank you! I’m glad I could help. If you need anything else—tracking, returns, payments, or address changes—just tell me."
    ],
    [
      'id' => 'greet_bye',
      'titles' => ['bye','goodbye','see you','later','ok na','that is all','that s all'],
      'answer' => "Thanks for chatting with Omacha-Shop. Have a great day!"
    ],
    [
      'id' => 'greet_identity',
      'titles' => ['who are you','what are you','are you a bot','omacha shop support','what can you do'],
      'answer' => "I’m Omacha-Shop’s support chatbot for our shop in San Fernando, La Union (PH). I give short, precise answers about login/OTP, orders & tracking, returns/refunds, payments, and address/account changes."
    ],

    // ---- Shop identity: name + address ----
    [
      'id' => 'shop_name_address',
      'titles' => [
        'shop name','store name','company name','your name','what is your shop name','what is your store name',
        'where are you located','address','shop address','store address','location','where is your location',
        'where is omacha shop','omacha shop address','omacha-shop address','san fernando la union'
      ],
      'answer' => "Our shop is *Omacha-Shop*, located in *San Fernando, La Union*, *Philippines*."
    ],

    // ---- Proactive generic help / clarifying responses ----
    [
      'id' => 'help_generic',
      'titles' => [
        'help','need help','i need help','please help','help me','help pls','help po',
        'assist me','assistance','need assistance','can you assist','can you help',
        'can u help','can you help me','can you help me please','can you help me with something',
        'i have a question','quick question','can i ask something','may tanong ako','new to app can you help'
      ],
      'answer' => "Sure—what do you need help with? I can assist with login/OTP, order status & tracking, returns/refunds, payments, or address/account edits. If it’s an order, please share your Order ID so I can guide you faster."
    ],
    [
      'id' => 'help_new_user_plus_order',
      'titles' => ['im new to this app can you help me how to order','i m new to this app can you help me how to order','new user help order','first time how to order'],
      'answer' => "Here’s how to order: 1) Open a product and choose variation/quantity. 2) Tap Add to Cart or Buy Now. 3) Confirm address and shipping. 4) Pick payment (COD, GCash, card). 5) Review and Place Order. Need a tracking link after purchase?"
    ],
    [
      'id' => 'help_topic_menu',
      'titles' => ['what can you help with','what do you support','list of help topics','help topics','menu'],
      'answer' => "I can help with: • Login/OTP • Orders & tracking • Returns/Refunds • Payments (COD, GCash, card) • Address/account changes • App issues • Calculator (e.g., 20% of 1499). What do you need?"
    ],

    // ---- New user / onboarding ----
    [
      'id' => 'new_user_onboarding',
      'titles' => ['im new to this app','i am new to this app','new to app','new user','first time here','getting started','how to start','paano magsimula'],
      'answer' => "Welcome! Browse or search for items, read reviews, then add to cart and check out. I can guide you step-by-step—just say “how to order”."
    ],

    // ---- HOW-TO: Ordering & Account basics ----
    [
      'id' => 'how_to_order',
      'titles' => ['how to order','place order','ordering steps','buy now','paano umorder','order tutorial'],
      'answer' => "How to order: 1) Open a product and choose variation/quantity. 2) Tap Add to Cart or Buy Now. 3) Confirm address and shipping option. 4) Pick payment (COD, GCash, card). 5) Review fees/vouchers → Place Order. Save your Order ID."
    ],
    [
      'id' => 'signup_create_account',
      'titles' => ['sign up','signup','create account','register account','how to register'],
      'answer' => "Create an account: Me → Sign Up → use phone/email or Google/Apple/Facebook (if available). Enter the code we send, set your password, then finish your profile."
    ],
    [
      'id' => 'reset_password_steps',
      'titles' => ['forgot password','reset password','recover password'],
      'answer' => "Reset password: Log In → Forgot Password → choose email/phone → enter the code → set a new password. If the code doesn’t arrive after 60s, tap Resend and check SMS/Spam."
    ],
    [
      'id' => 'enable_2fa_steps',
      'titles' => ['enable 2fa','two factor','two-factor authentication','turn on 2fa'],
      'answer' => "Enable 2FA: Me → Settings → Security → Two-Factor Authentication → pick SMS, email, or authenticator (if offered) → verify to finish. This helps protect your account."
    ],
    [
      'id' => 'verify_email_phone_steps',
      'titles' => ['verify email','verify phone','email verification','phone verification'],
      'answer' => "Verify contact: Me → Settings → Account → Email/Phone → Send Code → enter the 6-digit code before it expires. If expired, request a new one and try again."
    ],

    // ---- Login/OTP/Account (reference answers) ----
    [
      'id' => 'login_001',
      'titles' => ['log in','login','sign in','cant login','can t login','otp not received','no code','verify account','resend code'],
      'answer' => "Open the Omacha-Shop app → Log In → enter your email/phone and password → tap Continue. If the OTP doesn’t arrive after 60 seconds, tap Resend. Check spam/SMS. Still no code? Update your number in Settings → Account or contact support."
    ],
    [
      'id' => 'account_delete',
      'titles' => ['delete account','close account','remove account'],
      'answer' => "Me → Settings → Account → Delete/Deactivate. Finish verification and confirm. Note: some data may be retained as required by law."
    ],
    [
      'id' => 'account_recover',
      'titles' => ['recover deleted account','restore deleted account'],
      'answer' => "After permanent deletion or after the grace period, recovery isn’t possible. You can create a new account with a different email/number."
    ],
  ];
}
