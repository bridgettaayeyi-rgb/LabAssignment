<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

if (!isset($_GET['session_id'])) {
    die("Session ID missing.");
}

$session_id = intval($_GET['session_id']);

$stmt = $conn->prepare("UPDATE sessions SET attendance_locked = 1 WHERE session_id = ?");
$stmt->bind_param("i", $session_id);
?>
<!DOCTYPE html>
<html>
<head>
  <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #f8edff, #efe6ff);
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
    .container {
        background: #ffffff;
        width: 450px;
        padding: 30px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        animation: fadeIn 0.4s ease-in-out;
    }

    h2 {
        color: #4a0044;
        margin-bottom: 15px;
        font-size: 26px;
    }

    p {
        font-size: 18px;
        margin: 10px 0;
        color: #333;
    }

    a.back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 18px;
        background: #7a1c7a;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 16px;
        transition: 0.3s;
    }

    a.back-btn:hover {
        background: #5c145c;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="container">
    <?php
    if ($stmt->execute()) {
        echo "<h2>Attendance Locked</h2>";
        echo "<p>No student can mark attendance anymore for this session.</p>";
        echo "<a href='facultydashboard.php'>Back</a>";
    } else {
        echo "Error locking attendance.";
    }
    ?>
  </div>
</body>
</html>


