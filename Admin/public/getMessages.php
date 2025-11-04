<?php
header('Content-Type: application/json');

$url = 'https://ntfy.sh/ADMIN/json?since=0';

$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => "Accept: application/json\r\n",
        "timeout" => 5
    ]
]);

$response = @file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo json_encode(["error" => "Failed to retrieve messages."]);
    exit;
}

$lines = explode("\n", trim($response));
$messages = [];

foreach ($lines as $line) {
    $line = trim($line);
    if ($line !== '') {
        $msg = json_decode($line, true);
        if ($msg) $messages[] = $msg;
    }
}

// 🔽 Reverse order so latest appears first
$messages = array_reverse($messages);

echo json_encode($messages);
?>