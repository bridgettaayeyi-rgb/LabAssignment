<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout | Attendance Management Portal</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #440000; 
      font-family: "Times New Roman", Times, serif;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      text-align: center;
    }

    .logo {
      width: 130px;
      position: absolute;
      top: 25px;
      right: 40px;
    }

    
    .logout-box {
      background-color: rgba(255, 255, 255, 0.15);
      padding: 50px 70px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(5px);
      max-width: 450px;
    }

    h2 {
      font-size: 30px;
      margin-bottom: 20px;
      letter-spacing: 1px;
    }

    p {
      font-size: 18px;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    a button {
      background-color: white;
      color: #440000;
      border: none;
      padding: 12px 35px;
      border-radius: 6px;
      font-size: 16px;
      font-family: "Times New Roman", Times, serif;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    a button:hover {
      background-color: #990000;
      color: white;
      transform: scale(1.05);
    }

    /* Footer */
    footer {
      background-color: #440000;
      color: white;
      text-align: center;
      padding: 12px;
      font-size: 14px;
      letter-spacing: 0.5px;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .logo {
        width: 90px;
        top: 10px;
        right: 20px;
      }

      .logout-box {
        width: 85%;
        padding: 30px;
      }

      h2 {
        font-size: 24px;
      }

      p {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>
  <!-- Ashesi Logo -->
  <img src="ashesilogo.png"
       alt="Ashesi University Logo" class="logo">

  
  <div class="logout-box">
    <h2>You've Successfully Logged Out</h2>
    <p>Thank you for using the <strong>Ashesi Attendance Management Portal.</strong><br>
       We hope to see you again soon!</p>
    <a href="Login.php">
      <button>Log In</button>
    </a>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>
</body>
</html>
