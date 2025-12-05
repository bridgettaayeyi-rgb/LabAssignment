<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: "Times New Roman", serif;
            color: #330000;
        }

        /* Header */
        h2 {
            background: #440000;
            color: white;
            text-align: center;
            padding: 25px 0 15px;
            margin: 0;
            font-size: 32px;
            letter-spacing: 1px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        /* Description text */
        p {
            text-align: center;
            font-size: 18px;
            margin-top: 15px;
            color: #4e0000;
        }

        /* Menu Container */
        ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            max-width: 900px;
            margin: 40px auto;
            padding: 0;
        }

        /* Menu Cards */
        ul li {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s ease;
            border-left: 8px solid #440000;
        }

        ul li:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.25);
        }

        ul li a {
            text-decoration: none;
            color: #440000;
            font-weight: bold;
        }

        ul li a:hover {
            color: #990000;
        }

    </style>
</head>

<body>

<h2>COURSE MANAGEMENT</h2>
<p>Manage your courses — create, edit, delete, and approve student join requests.</p>

<ul>
    <li><a href="createCourse.php">Create New Course</a></li>
    <li><a href="edit_course_form.php">Edit Course</a></li>
    <li><a href="delete_course.html">Delete Course</a></li>
    <li><a href="view_enrolled_students.php">Pending Student Requests</a></li>
    <li><a href="list_courses.php">View Courses</a></li>
</ul>

</body>
</html>
