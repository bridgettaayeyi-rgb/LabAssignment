<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

if (!isset($_GET['session_id'])) {
    die("Session ID missing.");
}

$session_id = intval($_GET['session_id']);

// Fetch students enrolled in this course
$query = "
SELECT st.student_id, st.first_name, st.last_name 
FROM students st
JOIN enrollments e ON st.student_id = e.student_id
JOIN sessions s ON e.course_id = s.course_id
WHERE s.session_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $session_id);
$stmt->execute();
$students = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Manual Attendance</title>
<style>
body {
    font-family: "Segoe UI", Tahoma, Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background: #f4f6f9;
    color: #333;
    line-height: 1.6;
}
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 25px;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

th {
    background: #2c3e50;
    color: #fff;
    padding: 14px 10px;
    font-weight: 600;
    text-align: left;
    font-size: 15px;
}

td {
    padding: 12px 10px;
    border-bottom: 1px solid #e6e6e6;
    font-size: 14px;
}

tr:last-child td {
    border-bottom: none;
}
tbody tr:hover {
    background: #f2f7ff;
}
select {
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    background: #fff;
    cursor: pointer;
    transition: border 0.2s ease;
}
.button {
    background-color: #660000;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s ease;
    }

select:focus {
    border-color: #3498db;
    outline: none;
}
@media (max-width: 600px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    th {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    td {
        border: none;
        padding: 12px 8px;
        position: relative;
        border-bottom: 1px solid #eee;
    }

    tr {
        margin-bottom: 15px;
        background: #fff;
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
}

</style>
</head>

<body>

<h2>Manual Attendance - Session <?= $session_id ?></h2>

<form method="POST" action="process_manualAttendance.php">

<input type="hidden" name="session_id" value="<?= $session_id ?>">

<table>
    <tr>
        <th>Student</th>
        <th>Status</th>
    </tr>

    <?php while ($s = $students->fetch_assoc()): ?>
    <tr>
        <td><?= $s['first_name'] . " " . $s['last_name'] ?></td>

        <td>
            <select name="status[<?= $s['student_id'] ?>]">
                <option value="">-- Select --</option>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
            </select>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<button type="submit">Save Attendance</button>
</form>
<a href="facultydashboard.php" class="button">Back to Dashboard</a>
</body>
</html>
