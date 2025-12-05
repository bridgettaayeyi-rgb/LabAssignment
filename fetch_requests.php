<?php
require "db_connect.php";

header("Content-Type: application/json");

// FETCH APPROVED STUDENTS
$approved_sql = "
SELECT cr.student_id, c.course_name
FROM course_requests cr
JOIN courses c ON cr.course_id = c.course_id
WHERE cr.status = 'approved'
";
$approved_result = $conn->query($approved_sql);

$approved = [];
while ($row = $approved_result->fetch_assoc()) {
    $approved[] = $row;
}

// FETCH PENDING REQUESTS
$pending_sql = "
SELECT cr.request_id, cr.student_id, c.course_name
FROM course_requests cr
JOIN courses c ON cr.course_id = c.course_id
WHERE cr.status = 'pending'
";
$pending_result = $conn->query($pending_sql);

$pending = [];
while ($row = $pending_result->fetch_assoc()) {
    $pending[] = $row;
}

// RETURN BOTH
echo json_encode([
    "approved" => $approved,
    "pending" => $pending
]);
