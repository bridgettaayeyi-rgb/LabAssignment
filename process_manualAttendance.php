<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$session_id = intval($_POST['session_id']);

foreach ($_POST['status'] as $student_id => $status) {
    if ($status == "") continue;

    // Insert or update
    $stmt = $conn->prepare("
        INSERT INTO attendance (session_id, student_id, status)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE status = VALUES(status)
    ");

    $stmt->bind_param("iis", $session_id, $student_id, $status);
    $stmt->execute();
}

echo "<h3>Attendance Updated Successfully</h3>";
echo "<a href='attendance_actions.php?session_id=$session_id'>Back</a>";
?>
