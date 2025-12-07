<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$faculty_id = $_SESSION['user_id'];

$session_id = intval($_POST['session_id'] ?? 0);
$topic = trim($_POST['topic'] ?? '');
$location = trim($_POST['location'] ?? '');
$date = $_POST['date'] ?? '';
$start_time = $_POST['start_time'] ?? '';
$end_time = $_POST['end_time'] ?? '';

// Validate required fields
if (!$session_id || !$topic || !$location || !$date || !$start_time || !$end_time) {
    die("All fields are required.");
}

// Update session
$stmt = $conn->prepare("
    UPDATE sessions s
    JOIN courses c ON s.course_id = c.course_id
    SET s.topic = ?, s.location = ?, s.date = ?, s.start_time = ?, s.end_time = ?
    WHERE s.session_id = ? AND c.faculty_id = ?
");
$stmt->bind_param("ssssiii", $topic, $location, $date, $start_time, $end_time, $session_id, $faculty_id);

if ($stmt->execute()) {
    header("Location: facultydashboard.php"); 
    exit;
} else {
    die("Error updating session: " . $stmt->error);
}
