<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Course</title>
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
        input, textarea {
            width: 100%;
            padding: 12px;
            border: none;
            outline: none;
            margin-bottom: 15px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        textarea { min-height: 100px; resize: vertical; }
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
        button:hover {
            background: #bc104a;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<h2>Create New Course</h2>

<form id="createCourseForm">
    <input type="text" name="course_name" id="course_name" placeholder="Course Name" required>
    <input type="text" name="course_code" id="course_code" placeholder="Course Code" required>
    <textarea name="description" id="description" placeholder="Description (optional)"></textarea>
    <button type="submit">Create Course</button>
</form>

<script>
document.getElementById("createCourseForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const course_name = document.getElementById("course_name").value.trim();
    const course_code = document.getElementById("course_code").value.trim();
    const description = document.getElementById("description").value.trim();

    if (!course_name || !course_code) {
        Swal.fire("Error", "Course Name and Course Code are required.", "error");
        return;
    }

    const formData = new FormData();
    formData.append("course_name", course_name);
    formData.append("course_code", course_code);
    formData.append("description", description);

    try {
        const res = await fetch("create_course.php", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            Swal.fire({
                icon: "success",
                title: "Course Created",
                text: data.message
            }).then(() => {
                window.location.href = "facultydashboard.php"; // change to faculty dashboard
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message
            });
        }
    } catch (err) {
        Swal.fire({
            icon: "error",
            title: "Unexpected Error",
            text: err
        });
        console.error(err);
    }
});
</script>

</body>
</html>
