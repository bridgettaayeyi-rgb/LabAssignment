<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

$session_id = intval($_GET['id'] ?? 0);
$faculty_id = $_SESSION['user_id'];

if ($session_id <= 0) {
    die("Invalid session.");
}

// Secure delete: only delete sessions owned by this faculty
$sql = "
DELETE s FROM sessions s
JOIN courses c ON s.course_id = c.course_id
WHERE s.session_id = ? AND c.faculty_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $session_id, $faculty_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Session deleted successfully.";
} else {
    echo "Unable to delete session.";
}
