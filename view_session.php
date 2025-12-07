<?php
$required_role = ["faculty", "intern"];
require "auth_check.php";
require "db_connect.php";

$faculty_id = $_SESSION['user_id'];

$query = "
SELECT s.*, c.course_name
FROM sessions s
JOIN courses c ON s.course_id = c.course_id
WHERE c.faculty_id = ?
ORDER BY s.date DESC, s.start_time ASC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>Upcoming Sessions</title>

<style>
    body { 
        font-family: 'Times New Roman', serif; 
        padding: 25px; 
        background: #f4f4f4; 
    }
    h2 { 
        text-align: center; 
        color: #440000; 
    }
    .cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 20px;
}

.session-card {
    background: #1e1e1e; /* Dark mode friendly */
    color: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.session-card h3 {
    margin-top: 0;
    font-size: 20px;
}

.session-card p {
    margin: 6px 0;
    font-size: 15px;
}

.session-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.4);
}
.manage-btn {
    display: inline-block;
    padding: 10px 18px;
    background-color: #440000;
    color: white;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    transition: background 0.3s, transform 0.2s;
}

.manage-btn:hover {
    background-color:  #660000;
    transform: translateY(-2px);
}


</style>
</head>

<body>

<h2>Upcoming & Past Sessions</h2>

<div class="cards-container">

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="session-card">
        <h3><?= htmlspecialchars($row['course_name']) ?></h3>
        <p><strong>Topic:</strong> <?= htmlspecialchars($row['topic']) ?></p>
        <p><strong>Date:</strong> <?= $row['date'] ?></p>
        <p><strong>Time:</strong> <?= $row['start_time'] ?> - <?= $row['end_time'] ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
        <a href="attendance_action.php?session_id=<?= $row['session_id'] ?>" 
           class="manage-btn">Manage Attendance</a>
    </div>
<?php endwhile; ?>

</div>


</body>
</html>
