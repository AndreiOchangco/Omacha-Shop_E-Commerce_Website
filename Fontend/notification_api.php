<?php
// Set headers FIRST
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Only POST method allowed']);
    exit();
}

try {
    // Get the raw POST data
    $json_input = file_get_contents('php://input');
    $input = json_decode($json_input, true);
    
    // Check if JSON is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }
    
    // Validate required fields - CHANGED: using 'user' instead of 'topic'
    if (empty($input['user']) || empty($input['title']) || empty($input['message'])) {
        throw new Exception('User, title, and message are required');
    }
    
    $user = trim($input['user']);
    $title = trim($input['title']);
    $message = trim($input['message']);
    
    // Format the notification text exactly as requested
    $notificationText = "Title: " . $title . "\n" . "Message: " . $message;
    
    // Send to ntfy.sh - CHANGED: using $user as the topic
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: text/plain',
            'content' => $notificationText,
            'timeout' => 10
        ]
    ]);
    
    $result = @file_get_contents("https://ntfy.sh/" . urlencode($user), false, $context);
    
    if ($result === false) {
        throw new Exception('Failed to send notification to ntfy.sh');
    }
    
    // Success response - CHANGED: using 'user' instead of 'topic'
    echo json_encode([
        'success' => true,
        'url' => "https://ntfy.sh/" . $user,
        'user' => $user
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>