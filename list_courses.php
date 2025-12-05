<?php
$required_role = "faculty";
require "auth_check.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Courses</title>
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
        .course-card a {
            padding: 10px;
            background: #440000;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            margin-top: 10px;
            transition: 0.2s;
        }
        .course-card a:hover { background: #bc104a; }
        .no-courses {
            font-size: 16px;
            color: #a01357;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<h2>My Courses</h2>
<div id="courses" class="course-container"></div>
<div id="no-courses" class="no-courses" style="display:none;">No courses found.</div>

<script>
async function loadCourses() {
    try {
        const res = await fetch('get_courses.php'); // your JSON endpoint
        const data = await res.json();

        const container = document.getElementById('courses');
        const noCourses = document.getElementById('no-courses');
        container.innerHTML = '';

        if(data.success && data.courses.length > 0){
            data.courses.forEach(course => {
                const div = document.createElement('div');
                div.classList.add('course-card');
                div.innerHTML = `
                    <h3>${course.name}</h3>
                    <p><strong>Course Code:</strong> ${course.code}</p>
                    <a href="edit_course_form.php?id=${course.id}">Edit Course</a>
                `;
                container.appendChild(div);
            });
            noCourses.style.display = 'none';
        } else {
            noCourses.style.display = 'block';
        }
    } catch(err) {
        console.error(err);
        Swal.fire('Error', 'Failed to load courses.', 'error');
    }
}

// Load courses on page load
loadCourses();
</script>

</body>
</html>