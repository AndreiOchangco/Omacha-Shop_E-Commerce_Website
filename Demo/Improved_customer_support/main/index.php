<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Customer Support</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrap">
  <div class="chat-card">
    <div class="chat-header">
      <div class="avatar">S</div>
      <div class="status"><span id="lastActive">Last Active (5 mins ago)</span></div>
    </div>

    <div id="chatBody" class="chat-body"></div>

    <div class="quick-row" id="quickRow"></div>

    <div class="composer">
      <input id="userInput" type="text" placeholder="Type your question..." autocomplete="off">
      <button id="sendBtn" aria-label="Send" class="send">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path d="M22 2L11 13"></path>
          <path d="M22 2L15 22l-4-9-9-4 20-7z"></path>
        </svg>
      </button>
    </div>
  </div>
</div>

<!-- moved all JS to /response/app.js -->
<script src="../response/app.js" defer></script>
</body>
</html>
