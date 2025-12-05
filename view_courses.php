<?php
$required_role = "student";
require "auth_check.php";
require "db_connect.php";

$student_id = $_SESSION['user_id'];

$query = "SELECT c.course_name, c.course_code
          FROM course_requests cr
          JOIN courses c ON cr.course_id = c.course_id
          WHERE cr.student_id = ? AND cr.status = 'approved'";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color:#660000; font-weight:bold;'>You are not enrolled in any courses yet.</p>";
    exit;
}

// Styled table output
echo "<table style='width:100%; border-collapse: collapse; font-family: Times, serif;'>";
echo "<thead style='background-color: #440000; color: white;'>
        <tr>
          <th style='padding:10px; border:1px solid #ccc;'>Course Code</th>
          <th style='padding:10px; border:1px solid #ccc;'>Course Name</th>
        </tr>
      </thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr style='border:1px solid #ccc; text-align:left;'>
            <td style='padding:8px; border:1px solid #ccc;'>" . htmlspecialchars($row['course_code']) . "</td>
            <td style='padding:8px; border:1px solid #ccc;'>" . htmlspecialchars($row['course_name']) . "</td>
          </tr>";
}

echo "</tbody></table>";

$stmt->close();
$conn->close();
?>
