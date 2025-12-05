<?php
session_start();
require "db_connect.php";
require "auth_check.php"; // ensure user is logged in and is faculty

header("Content-Type: application/json");

// Ensure the user is faculty
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'faculty') {
    echo json_encode(["success" => false, "message" => "Unauthorized: Only faculty can create courses."]);
    exit;
}

// Collect POST data
$course_name = trim($_POST['course_name'] ?? '');
$course_code = trim($_POST['course_code'] ?? '');
$description = trim($_POST['description'] ?? '');
$faculty_id = $_SESSION['faculty_id'] ?? 0;

// Validate required fields
if ($course_name === "" || $course_code === "" || $faculty_id <= 0) {
    echo json_encode(["success" => false, "message" => "Course Name, Course Code, and Faculty ID are required."]);
    exit;
}

// Prepare and execute insert
$stmt = $conn->prepare("INSERT INTO courses (course_name, course_code, description, faculty_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $course_name, $course_code, $description, $faculty_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Course created successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error creating course: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
