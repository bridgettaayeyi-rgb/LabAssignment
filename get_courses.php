<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

header('Content-Type: application/json');

try {
    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT course_id, course_name, course_code FROM courses WHERE faculty_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = [
            'id' => intval($row['course_id']),
            'name' => $row['course_name'],
            'code' => $row['course_code']
        ];
    }

    echo json_encode([
        'success' => true,
        'courses' => $courses
    ]);

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching courses: ' . $e->getMessage()
    ]);
}

$conn->close();
?>
