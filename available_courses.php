<?php
$required_role = "student";
require "auth_check.php";
require "db_connect.php";

$student_id = $_SESSION['user_id'];

$query = "
    SELECT course_id, course_name, description
    FROM courses
    WHERE course_id NOT IN (
        SELECT course_id FROM course_requests WHERE student_id = ?
    )
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Courses</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f4ff;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 { color: #330000; }
        .course-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1000px;
            margin-top: 20px;
        }
        .course-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .course-card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #440000;
        }
        .course-card p {
            font-size: 14px;
            color: #333333;
            flex-grow: 1;
        }
        .course-card button {
            padding: 10px;
            background: #440000;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }
        .course-card button:hover { background: #bc104a; }
        .no-courses {
            font-size: 16px;
            color: #a01357;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<h2>New Courses Available</h2>

<?php if ($result->num_rows === 0): ?>


<div class="no-courses">No new courses available.</div>


<?php else: ?>


<div class="course-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="course-card">
            <h3><?php echo htmlspecialchars($row['course_name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description'] ?: 'No description'); ?></p>
            <button onclick="requestJoin(<?php echo $row['course_id']; ?>)">Request to Join</button>
        </div>
    <?php endwhile; ?>
</div>


<?php endif; ?>

<script>
function requestJoin(courseId) {
    Swal.fire({
        title: 'Request to join this course?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, request',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('request_join.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'course_id=' + courseId
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    Swal.fire('Success', 'Request sent successfully!', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Unexpected error occurred.', 'error');
            });
        }
    });
}
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
