<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT course_id, course_name, course_code FROM courses WHERE faculty_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = [
            'course_id' => intval($row['course_id']),
            'course_name' => $row['course_name'],
            'course_code' => $row['course_code']
        ];
    }

    echo json_encode($courses);

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([]);
}

$conn->close();
?>
