<?php
require "db_connect.php";

$request_id = $_GET['request_id'];
$action = $_GET['action'];

if ($action === "approve") {
    $sql = "UPDATE course_requests SET status = 'approved' WHERE request_id = ?";
} else {
    $sql = "UPDATE course_requests SET status = 'rejected' WHERE request_id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $request_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}
