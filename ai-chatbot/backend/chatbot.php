<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "db.php";

// Pokea message kutoka frontend
$data = json_decode(file_get_contents("php://input"), true);
$userMessage = $data["message"] ?? "";

if (!$userMessage) {
    echo json_encode(["reply" => "Tafadhali andika ujumbe."]);
    exit;
}

// OpenAI API configuration
$apiKey = ""; // badilisha na key yako
$apiUrl = "https://api.openai.com/v1/chat/completions";

// Prepare request payload
$postData = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $userMessage]
    ],
    "temperature" => 0.7,
    "max_tokens" => 200
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(["reply" => "Kosa la network: ".curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

$respData = json_decode($response, true);
if (isset($respData["choices"][0]["message"]["content"])) {
    $botReply = $respData["choices"][0]["message"]["content"];
} else {
    $botReply = "API Error: " . json_encode($respData);
}


// Hifadhi kwenye database
$stmt = $conn->prepare("INSERT INTO chats (user_message, bot_reply) VALUES (?, ?)");
$stmt->bind_param("ss", $userMessage, $botReply);
$stmt->execute();

// Rudisha reply
echo json_encode(["reply" => $botReply]);

$conn->close();
