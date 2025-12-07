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
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>Delete Session</title>

<style>
    body { font-family: 'Times New Roman'; padding: 25px; background: #f4f4f4; }
    h2 { text-align: center; color: #440000; }
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
.card-action {
    margin-top: 10px;
}

.delete-btn {
    background-color: #660000;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.delete-btn:hover {
    background-color: #440000;
}
</style>
</head>

<body>

<h2>Delete a Session</h2>

<div class="cards-container">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="session-card">
        <h3><?= htmlspecialchars($row['course_name']) ?></h3>
        <p><strong>Topic:</strong> <?= htmlspecialchars($row['topic']) ?></p>
        <p><strong>Date:</strong> <?= $row['date'] ?></p>
        <div class="card-action">
            <a href="process_deleteSession.php?id=<?= $row['session_id'] ?>" onclick="return confirm('Delete session?')">
                <button class="delete-btn">Delete</button>
            </a>
        </div>
    </div>
<?php endwhile; ?>

</div>


</body>
</html>
