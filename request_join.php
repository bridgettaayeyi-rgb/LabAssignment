<?php
session_start();
require "db_connect.php";
header('Content-Type: application/json');

// Ensure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    echo json_encode(["success" => false, "message" => "Unauthorized: Only students can request courses."]);
    exit;
}

$student_id = $_SESSION['user_id'];
$course_id = intval($_POST['course_id'] ?? 0);

if ($course_id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid course ID."]);
    exit;
}

// Optional: check that course exists
$stmt_course = $conn->prepare("SELECT course_id FROM courses WHERE course_id = ?");
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result_course = $stmt_course->get_result();
if ($result_course->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Course does not exist."]);
    $stmt_course->close();
    $conn->close();
    exit;
}
$stmt_course->close();

// Check if request already exists
$stmt_check = $conn->prepare("SELECT * FROM course_requests WHERE student_id = ? AND course_id = ?");
$stmt_check->bind_param("ii", $student_id, $course_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "You have already requested this course."]);
    $stmt_check->close();
    $conn->close();
    exit;
}
$stmt_check->close();

// Insert new course request
$stmt_insert = $conn->prepare("INSERT INTO course_requests (student_id, course_id, status) VALUES (?, ?, 'pending')");
$stmt_insert->bind_param("ii", $student_id, $course_id);

if ($stmt_insert->execute()) {
    echo json_encode(["success" => true, "message" => "Request sent successfully."]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt_insert->error . " (Code: " . $stmt_insert->errno . ")"
    ]);
}

$stmt_insert->close();
$conn->close();
?>
