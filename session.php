<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$faculty_id = $_SESSION['user_id'];
$courses = $conn->query("SELECT course_id, course_name FROM courses WHERE faculty_id = $faculty_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Class Session</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f4ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
        }
        h2 { color: #330000; margin-bottom: 20px; }
        form {
            background: white;
            padding: 25px;
            width: 350px;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        }
        input, select {
            width: 100%;
            padding: 12px;
            border: none;
            outline: none;
            margin-bottom: 15px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #440000;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(106, 13, 173, 0.3);
            transition: 0.2s;
        }
        button:hover { background: #bc104a; transform: translateY(-2px); }
    </style>
</head>
<body>

<h2>Create New Class Session</h2>

<form id="createSessionForm">
    <select name="course_id" id="course_id" required>
        <option value="">Select Course</option>
        <?php while($row = $courses->fetch_assoc()): ?>
            <option value="<?= $row['course_id'] ?>"><?= htmlspecialchars($row['course_name']) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="text" name="topic" id="topic" placeholder="Topic" required>
    <input type="text" name="location" id="location" placeholder="Location" required>
    <input type="date" name="date" id="date" required>
    <input type="time" name="start_time" id="start_time" required>
    <input type="time" name="end_time" id="end_time" required>
    <button type="submit">Create Session</button>
</form>
<a href="facultydashboard.php" class="button">Back to Dashboard</a>
<script>
document.getElementById("createSessionForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append("course_id", document.getElementById("course_id").value);
    formData.append("topic", document.getElementById("topic").value.trim());
    formData.append("location", document.getElementById("location").value.trim());
    formData.append("date", document.getElementById("date").value);
    formData.append("start_time", document.getElementById("start_time").value);
    formData.append("end_time", document.getElementById("end_time").value);

    try {
        const res = await fetch("process_session.php", {
            method: "POST",
            body: formData
        });

        const data = await res.text(); // If process_session.php returns plain text
        // Or use res.json() if you update process_session.php to return JSON

        if (data.startsWith("Error")) {
            Swal.fire("Error", data, "error");
        } else {
            Swal.fire({
                icon: "success",
                title: "Session Created"
            }).then(() => {
                window.location.href = "session_overview.php"; // Redirect to your session list/dashboard
            });
        }

    } catch (err) {
        Swal.fire("Unexpected Error", err, "error");
        console.error(err);
    }
});
</script>

</body>
</html>
