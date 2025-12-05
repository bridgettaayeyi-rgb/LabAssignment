<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$faculty_id = $_SESSION['user_id'];

$courses = $conn->query("SELECT course_id, course_name FROM courses WHERE faculty_id = $faculty_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Session</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: linear-gradient(135deg, #f3e7ff, #f8f4ff);
            padding: 40px 0;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4a0044;
            font-size: 28px;
            font-weight: 700;
        }

        .form-container {
            background: white;
            width: 420px;
            padding: 25px 30px;
            margin: auto;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.4s ease-in-out;
        }

        label {
            font-weight: 600;
            margin-top: 12px;
            display: block;
            color: #4a0044;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 10px;
            border: 1px solid #c7b5d6;
            background: #faf7ff;
            font-size: 15px;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #7a1c7a;
            outline: none;
            background: #fff;
            box-shadow: 0 0 8px rgba(122, 28, 122, 0.2);
        }

        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background: #7a1c7a;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5c145c;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<h2>Create Class Session</h2>

<div class="form-container">
<form method="POST" action="process_session.php">

    <label>Course:</label>
    <select name="course_id" required>
        <option value="">Select Course</option>
        <?php while($row = $courses->fetch_assoc()): ?>
            <option value="<?= $row['course_id'] ?>">
                <?= $row['course_name'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Topic:</label>
    <input type="text" name="topic" placeholder="Enter session topic..." required>

    <label>Location:</label>
    <input type="text" name="location" placeholder="e.g. CLB 202" required>

    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Start Time:</label>
    <input type="time" name="start_time" required>

    <label>End Time:</label>
    <input type="time" name="end_time" required>

    <button type="submit">Create Session</button>
</form>
</div>

</body>
</html>
