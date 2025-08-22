<?php
// Unganisha na database
include "db.php";

// Chukua messages zote kutoka chats table
$sql = "SELECT * FROM chats ORDER BY created_at ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Chat History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    .chat-box {
      max-width: 700px;
      margin: 0 auto;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .msg {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
    }
    .user {
      background: #d1e7dd;
      text-align: right;
    }
    .bot {
      background: #f8d7da;
      text-align: left;
    }
    small {
      display: block;
      color: #777;
      font-size: 0.8em;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <h2>Chat History</h2>
  <div class="chat-box">
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="msg user">
          <strong>You:</strong> <?php echo htmlspecialchars($row['user_message']); ?>
          <small><?php echo $row['created_at']; ?></small>
        </div>
        <div class="msg bot">
          <strong>Bot:</strong> <?php echo htmlspecialchars($row['bot_reply']); ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No chat history found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
