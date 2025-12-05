<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unauthorized Access</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #440000; 
            font-family: "Times New Roman", Times, serif;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 40px 60px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 380px;
        }
        a {
            color: #ffd9d9;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Access Denied</h1>
        <p>You do not have permission to view this page.</p>
        <a href="Login.php">Go to Login</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>
