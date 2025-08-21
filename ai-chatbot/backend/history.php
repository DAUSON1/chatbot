<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include "db.php";

// Chukua messages zote kutoka DB
$result = $conn->query("SELECT user_message, bot_reply, created_at FROM chats ORDER BY created_at ASC");

$chats = [];
while ($row = $result->fetch_assoc()) {
    $chats[] = $row;
}

echo json_encode($chats);

$conn->close();
