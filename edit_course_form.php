<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

$query = "SELECT * FROM courses WHERE faculty_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']); 
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Course to Edit</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 70%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #440000; color: white; }
        .button {
            background: #440000;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            text-decoration: none;
        }
        a.edit-btn {
            background: #440000;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            text-decoration: none;
        }
        a.edit-btn:hover { background: #660000; }
    </style>
</head>
<body>

<h2>Select a Course to Edit</h2>

<?php if ($result->num_rows === 0): ?>
    <p>No courses found for your account.</p>
<?php else: ?>
<table>
    <tr>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['course_code']); ?></td>
        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
        <td>
            <a class="edit-btn" href="update_course.php?id=<?php echo $row['course_id']; ?>">Edit</a>
        </td>
    </tr>
    <?php } ?>
</table>
<a href="facultydashboard.php" class="button">Back to Dashboard</a>
<?php endif; ?>

</body>
</html>
