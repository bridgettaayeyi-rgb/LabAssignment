<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

header('Content-Type: application/json');

// Get course ID from query string
$course_id = intval($_GET['id'] ?? 0);

if ($course_id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid course ID."]);
    exit;
}

// Delete only if this faculty owns the course
$stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ? AND faculty_id = ?");
$stmt->bind_param("ii", $course_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Course deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Course not found or you do not have permission to delete it."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
