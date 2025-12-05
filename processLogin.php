<?php
session_start();
require "db_connect.php";

header("Content-Type: application/json");

// Collect POST data
$user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($user_id) || empty($password)) {
    echo json_encode(["success" => false, "reason" => "missing_fields"]);
    exit;
}

// Fetch user
$stmt = $conn->prepare("SELECT user_id, first_name, last_name, role, password_hash FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "reason" => "not_found"]);
    exit;
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password_hash'])) {
    echo json_encode(["success" => false, "reason" => "wrong_password"]);
    exit;
}

// Set session
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['role'] = $user['role'];

// If faculty, ensure faculty table has a row
if ($user['role'] === 'faculty') {
    $_SESSION['faculty_id'] = $user['user_id'];
    $conn->query("INSERT IGNORE INTO faculty (faculty_id) VALUES ({$user['user_id']})");
}
if ($user['role'] === 'student') {
    $_SESSION['student_id'] = $user['user_id'];
    $conn->query("INSERT IGNORE INTO students (student_id) VALUES ({$user['user_id']})");
}

// Determine dashboard
switch ($user['role']) {
    case 'student': $redirect = "studentdashboard.php"; break;
    case 'faculty': $redirect = "facultydashboard.php"; break;
    case 'intern': $redirect = "interndashboard.php"; break;
    default: $redirect = "login.php"; break;
}

// Return JSON response
echo json_encode([
    "success" => true,
    "user_id" => $user['user_id'],
    "first_name" => $user['first_name'],
    "last_name" => $user['last_name'],
    "role" => $user['role'],
    "redirect" => $redirect
]);

$stmt->close();
$conn->close();
?>
