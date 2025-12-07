<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

if (!isset($_GET['session_id'])) {
    die("Session ID missing.");
}

$session_id = intval($_GET['session_id']);

// Generate random 6-digit numeric code
$code = substr(str_shuffle("0123456789"), 0, 6);

// Code expires in 30 minutes
$expires_at = date("Y-m-d H:i:s", time() + 1800);

$stmt = $conn->prepare("INSERT INTO attendance_codes (session_id, code, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $session_id, $code, $expires_at);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Code</title>
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

        .code-box {
            font-size: 36px;
            font-weight: bold;
            color: #7a1c7a;
            background: #f9f3ff;
            padding: 15px 0;
            border-radius: 12px;
            margin: 15px 0;
            letter-spacing: 4px;
            border: 2px dashed #7a1c7a;
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
    echo "<h2>Attendance Code Generated</h2>";
    echo "<p><strong>Code:</strong> $code</p>";
    echo "<p><strong>Expires at:</strong> $expires_at</p>";
    echo "<a href='facultydashboard.php'>Back</a>";
} else {
    echo "Error generating code.";
}
?>
</div>

</body>
</html>