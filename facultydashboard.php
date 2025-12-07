<?php
$required_role = "faculty";
require "auth_check.php";
require "db_connect.php";
$faculty_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Dashboard | Attendance Management Portal</title>
  <style>
    /* Page Setup */
    body {
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
      font-family: "Times New Roman", Times, serif;
      color: #330000;
    }

    /* Header */
    header {
      background-color: #440000; 
      color: white;
      padding: 30px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    header h2 {
      margin: 0;
      font-size: 32px;
      letter-spacing: 1px;
    }

    header h4 {
      margin-top: 10px;
      font-weight: normal;
      font-size: 18px;
      color: #f5f5f5;
      line-height: 1.6;
    }

    /* Navigation Bar */
    nav {
      background-color: #440000;
      padding: 12px 0;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      position: sticky;
      top: 0;
      z-index: 10;
    }

    nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      margin: 8px 15px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 8px 16px;
      border-radius: 5px;
      transition: 0.3s;
    }

    nav ul li a:hover {
      background-color: #990000;
      transform: scale(1.05);
    }

    /* Section Styling */
    section {
      background-color: white;
      margin: 40px auto;
      padding: 30px;
      border-radius: 10px;
      width: 80%;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    section h3 {
      color: #660000;
      font-size: 24px;
      margin-bottom: 10px;
    }

    section p {
      color: #333;
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    section ul {
      list-style: none;
      padding-left: 0;
    }

    section ul li {
      margin: 8px 0;
    }

    section ul li a {
      color: #440000;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    section ul li a:hover {
      color: #440000;
      text-decoration: underline;
    }

    /* Footer */
    footer {
      background-color: #440000;
      color: white;
      text-align: center;
      padding: 12px;
      font-size: 14px;
      letter-spacing: 0.5px;
      position: relative;
      bottom: 0;
      width: 100%;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      nav ul {
        flex-direction: column;
        align-items: center;
      }

      section {
        width: 90%;
        padding: 20px;
      }

      header h2 {
        font-size: 26px;
      }

      header h4 {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h2>FACULTY DASHBOARD</h2>
    <h4>Hello Professor! This is your control center for managing courses, tracking sessions, and viewing attendance reports.</h4>
  </header>

  <!-- Navigation Bar -->
  <nav>
    <ul>
      <li><a href="course_management.php">Course Management</a></li>
      <li><a href="session_overview.php">Session Overview</a></li>
      <li><a href="#attendance-reports">Attendance Reports</a></li>
      <li><a href="#student-performance">Student Performance</a></li>
      <li><a href="logout.php">Log Out</a></li>
    </ul>
  </nav>
  <section id="attendance-reports">
    <h3>Attendance Reports</h3>
    <p>Generate, view, and export attendance data for your sessions.</p>
    <ul>
      <li><a href="#generatedata">Generate Report</a></li>
      <li><a href="#pastdata">View Past Reports</a></li>
      <li><a href="#download">Export to CSV</a></li>
    </ul>
  </section>
  <section id="student-performance">
    <h3>Student Performance</h3>
    <p>Analyze student participation and performance across sessions.</p>
    <ul>
      <li><a href="#individualperformance">View Individual Performance</a></li>
      <li><a href="#attendancetrends">Attendance Trends</a></li>
      <li><a href="#performancecomparison">Performance Comparison</a></li>
    </ul>
    
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>

</body>
</html>
