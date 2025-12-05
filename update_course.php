<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";

$course_id = intval($_GET['id'] ?? 0);

if ($course_id <= 0) {
    die("Invalid course ID.");
}

// Fetch course details
$stmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ? AND faculty_id = ?");
$stmt->bind_param("ii", $course_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Course not found or you don't have permission to edit it.");
}

$course = $result->fetch_assoc();
$redirect = "facultydashboard.php"; // faculty dashboard

// Handle form submission
$update_success = false;
$error_msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = trim($_POST['course_name']);
    $course_code = trim($_POST['course_code']);
    $description = trim($_POST['description']);
    $credit_hours = intval($_POST['credit_hours'] ?? 0);

    $update = $conn->prepare("UPDATE courses SET course_name = ?, course_code = ?, description = ?, credit_hours = ? WHERE course_id = ? AND faculty_id = ?");
    $update->bind_param("sssiii", $course_name, $course_code, $description, $credit_hours, $course_id, $_SESSION['user_id']);
    
    if ($update->execute()) {
        $update_success = true;
    } else {
        $error_msg = "Error updating course: " . $update->error;
    }
    $update->close();
}
$stmt->close();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Edit Course</title>
    <style>
        body { 
            font-family: Arial; padding: 20px; 
        }
        input, textarea { 
            width: 100%; padding: 10px; margin: 8px 0; border-radius: 6px; border: 1px solid #ccc; 
        }
        button { 
            padding: 10px 15px; border: none; border-radius: 6px; background: #440000; color: white; cursor: pointer; 
        }
        button:hover {
             background: #660000; 
            }
        .error { 
            margin: 10px 0; color: red; 
        }
        label {
             font-weight: bold; 
            }
    </style>
</head>
<body>

<h2>Edit Course</h2>

<?php if (!empty($error_msg)) echo "<div class='error'>{$error_msg}</div>"; ?>

<form method="post">
    <label>Course Name:</label>
    <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>

```
<label>Course Code:</label>
<input type="text" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required>

<label>Description:</label>
<textarea name="description"><?php echo htmlspecialchars($course['description']); ?></textarea>

<label>Credit Hours:</label>
<input type="number" name="credit_hours" value="<?php echo intval($course['credit_hours']); ?>" min="0">

<button type="submit">Update Course</button>
```

</form>

<?php if ($update_success): ?>

<script>
    alert("Course updated successfully!");
    window.location.href = "<?php echo $redirect; ?>";
</script>

<?php endif; ?>

</body>
</html>
