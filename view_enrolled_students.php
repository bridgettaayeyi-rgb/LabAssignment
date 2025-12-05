<?php
$required_role = "faculty";
require "auth_check.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrolled Students</title>

    <style>
        body {
            font-family: Times, serif;
            padding: 20px;
            background: #f8f8f8;
        }

        h2 {
            color: #440000;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        th {
            background: #440000;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        button {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .approve { background: #008000; color: white; }
        .reject  { background: #990000; color: white; }
    </style>
</head>

<body>

<h2>Enrolled Students</h2>
<p>Below are students who have joined or requested to join your courses.</p>

<h3>Approved Students</h3>
<table id="approvedTable">
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Course</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<br><br>

<h3>Pending Requests</h3>
<table id="pendingTable">
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Student ID</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<script>
async function loadStudents() {
    let res = await fetch("fetch_enrolled_students.php");
    let data = await res.json();

    let approvedBody = document.querySelector("#approvedTable tbody");
    let pendingBody  = document.querySelector("#pendingTable tbody");

    approvedBody.innerHTML = "";
    pendingBody.innerHTML = "";

    // Render approved students
    data.approved.forEach(st => {
        approvedBody.innerHTML += `
            <tr>
                <td>${st.student_id}</td>
                <td>${st.course_name}</td>
            </tr>
        `;
    });

    // Render pending requests
    data.pending.forEach(req => {
        pendingBody.innerHTML += `
            <tr>
                <td>${req.request_id}</td>
                <td>${req.student_id}</td>
                <td>${req.course_name}</td>
                <td>
                    <button class="approve" onclick="processRequest(${req.request_id}, 'approve')">Approve</button>
                    <button class="reject" onclick="processRequest(${req.request_id}, 'reject')">Reject</button>
                </td>
            </tr>
        `;
    });
}

async function processRequest(id, action) {
    let res = await fetch(`process_request.php?request_id=${id}&action=${action}`);
    let result = await res.json();

    if (result.success) {
        alert("Request processed successfully.");
        loadStudents();
    } else {
        alert(result.message);
    }
}

loadStudents(); // Load on page start
</script>
<button onclick="window.location.href='facultydashboard.php';">
    ← Back to Dashboard
</button>
</body>
</html>
