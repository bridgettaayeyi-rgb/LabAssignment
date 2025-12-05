<?php
session_start();
require "db_connect.php"; // your database connection

header("Content-Type: application/json");

// Collect POST data
$user_id = intval($_POST['school_id'] ?? 0); 
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$role = trim($_POST['role'] ?? '');
$password = $_POST['password'] ?? '';

// Validate required fields
if ($user_id <= 0 || !$first_name || !$last_name || !$email || !$dob || !$role || !$password) {
    echo json_encode(["success" => false, "message" => "All fields are required and School ID must be valid."]);
    exit;
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if user_id or email already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ? OR email = ?");
$stmt->bind_param("is", $user_id, $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "User ID or Email already exists"]);
    exit;
}

// Insert new user with provided user_id
$stmt = $conn->prepare("INSERT INTO users (user_id, first_name, last_name, email, dob, role, password_hash) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("issssss", $user_id, $first_name, $last_name, $email, $dob, $role, $password_hash);

if ($stmt->execute()) {
    // Set session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['role'] = $role;

    // Add to role-specific table
    if ($role === 'faculty') {
        $conn->query("INSERT INTO faculty (faculty_id) VALUES ($user_id)");
        $_SESSION['faculty_id'] = $user_id;
    } elseif ($role === 'student') {
        $conn->query("INSERT INTO students (student_id) VALUES ($user_id)");
        $_SESSION['student_id'] = $user_id;
    }

    // Determine dashboard
    $dashboard = '';
    if ($role === 'student') $dashboard = "studentdashboard.php";
    elseif ($role === 'faculty') $dashboard = "facultydashboard.php";
    else $dashboard = "interndashboard.php";

    echo json_encode([
        "success" => true,
        "redirect" => $dashboard
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Error creating account: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
