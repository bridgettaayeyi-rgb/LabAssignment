<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$session_id = intval($_GET['id'] ?? 0);
$faculty_id = $_SESSION['user_id'];

// Fetch session
$stmt = $conn->prepare("
    SELECT s.*, c.course_name
    FROM sessions s
    JOIN courses c ON s.course_id = c.course_id
    WHERE s.session_id = ? AND c.faculty_id = ?
");
$stmt->bind_param("ii", $session_id, $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Session not found or you don't have permission.");
}

$session = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Session</title>
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

<h2>Edit Session for <?= htmlspecialchars($session['course_name']) ?></h2>

<form method="POST" action="process_editSession.php">
    <input type="hidden" name="session_id" value="<?= $session['session_id'] ?>">
    <label>Topic:</label>
    <input type="text" name="topic" value="<?= htmlspecialchars($session['topic']) ?>" required>
    <label>Location:</label>
    <input type="text" name="location" value="<?= htmlspecialchars($session['location']) ?>" required>
    <label>Date:</label>
    <input type="date" name="date" value="<?= $session['date'] ?>" required>
    <label>Start Time:</label>
    <input type="time" name="start_time" value="<?= $session['start_time'] ?>" required>
    <label>End Time:</label>
    <input type="time" name="end_time" value="<?= $session['end_time'] ?>" required>
    <button type="submit">Update Session</button>
</form>
<a href="facultydashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
