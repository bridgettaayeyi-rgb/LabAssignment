<?php
$required_role = "student";
require "auth_check.php";
require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code']);
    $student_id = $_SESSION['user_id'];

    // Check code validity
    $stmt = $conn->prepare("
        SELECT session_id, expires_at FROM attendance_codes 
        WHERE code = ? AND expires_at > NOW()
    ");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid or expired code.");
    }

    $data = $result->fetch_assoc();
    $session_id = $data['session_id'];

    // Check if attendance locked
    $lock = $conn->prepare("SELECT attendance_locked FROM sessions WHERE session_id = ?");
    $lock->bind_param("i", $session_id);
    $lock->execute();
    $lock_result = $lock->get_result()->fetch_assoc();

    if ($lock_result['attendance_locked'] == 1) {
        die("Attendance is closed for this session.");
    }

    // Mark attendance
    $insert = $conn->prepare("
        INSERT INTO attendance (session_id, student_id, status)
        VALUES (?, ?, 'present')
        ON DUPLICATE KEY UPDATE status = 'present'
    ");
    $insert->bind_param("ii", $session_id, $student_id);
    $insert->execute();

    echo "<h2>Attendance Marked Successfully</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Mark Attendance</title>
<style>
    body {
        font-family: "Segoe UI", sans-serif;
        background: linear-gradient(135deg, #f3e7ff, #f8f4ff);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        text-align: center;
        width: 350px;
        animation: fadeIn 0.4s ease-in-out;
    }

    h2 {
        color: #4a0044;
        margin-bottom: 25px;
        font-size: 24px;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #c7b5d6;
        font-size: 16px;
        background: #faf7ff;
        transition: 0.3s;
    }

    input[type="text"]:focus {
        border-color: #7a1c7a;
        outline: none;
        background: #fff;
        box-shadow: 0 0 8px rgba(122, 28, 122, 0.2);
    }

    button {
        width: 100%;
        padding: 12px;
        background: #7a1c7a;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #5c145c;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>

<h2>Enter Attendance Code</h2>

<form method="POST">
    <input type="text" name="code" placeholder="Enter Code" required>
    <button type="submit">Submit</button>
</form>
<a href="studentdashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
