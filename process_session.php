<?php
session_start();
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

header("Content-Type: application/json");

// Collect and sanitize POST data
$course_id   = intval($_POST['course_id'] ?? 0);
$topic       = trim($_POST['topic'] ?? '');
$location    = trim($_POST['location'] ?? '');
$date        = $_POST['date'] ?? '';
$start_time  = $_POST['start_time'] ?? '';
$end_time    = $_POST['end_time'] ?? '';

// Basic validation
if ($course_id <= 0 || !$topic || !$location || !$date || !$start_time || !$end_time) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required."
    ]);
    exit;
}

// Optional: check end_time > start_time
if ($end_time <= $start_time) {
    echo json_encode([
        "success" => false,
        "message" => "End time must be after start time."
    ]);
    exit;
}

// Insert session
$stmt = $conn->prepare("
    INSERT INTO sessions (course_id, topic, location, date, start_time, end_time)
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("isssss", $course_id, $topic, $location, $date, $start_time, $end_time);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Class session created successfully!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
