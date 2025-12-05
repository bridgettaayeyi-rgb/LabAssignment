<?php
$required_role = "student";
require "auth_check.php";
require "db_connect.php";
$student_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management Portal</title>
    <style>
        /* General Page Styling */
        body {
          margin: 0;
          padding: 0;
          background-color: #f8f8f8;
          font-family: "Times New Roman", Times, serif;
          color: #330000;
        }
    
        /* Header */
        h2 {
          background-color: #440000; /* Ashesi wine */
          color: white;
          text-align: center;
          padding: 25px 0 10px 0;
          margin: 0;
          font-size: 32px;
          letter-spacing: 1px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    
        h4 {
          text-align: center;
          background-color: #440000;
          color: #f5f5f5;
          font-weight: normal;
          margin: 0;
          padding-bottom: 20px;
          line-height: 1.5;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
    
        /* Navigation Bar */
        nav {
          background-color: #440000;
          padding: 12px 0;
          box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
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
          transition: 0.3s ease;
        }
    
        nav ul li a:hover {
          background-color: #990000;
          transform: scale(1.05);
        }
    
        /* Sections */
        section {
          background-color: white;
          margin: 40px auto;
          padding: 30px;
          border-radius: 10px;
          width: 80%;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
          color: #660000;
          text-decoration: none;
          font-weight: bold;
          transition: 0.3s ease;
        }
    
        section ul li a:hover {
          color: #990000;
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
    
          h2 {
            font-size: 26px;
          }
    
          h4 {
            font-size: 16px;
          }
        }
      </style>
</head>
<body>
     <!--student dashboard;-->
     <h2>STUDENT DASHBOARD</h2>
     <h4>Hello Student! This is your personalized dashboard for viewing attendance records,
         course details, and session reports.</h4>
         <nav>
             <ul>
                 <li><a href="#view-courses">My Courses</a></li>
                 <li><a href="#my-schedule">My Schedule</a></li>
                 <li><a href="#my-grades">My Grades</a></li>
                 <li><a href="#settings">Settings</a></li>
             </ul>
         </nav>
     <section id="view-courses">
         <h3>My Courses</h3>
         <p>Check your courses and explore other courses too.</p>
         <ul>
         <li><a href="view_courses.php">View Enrolled Courses</a></li>
         <li><a href="available_courses.php">Check New Courses</a></li>
         </ul>
     </section>
     <section id="my-schedule">
         <h3>My Schedule</h3>
         <p>Check your class schedule and upcoming sessions.</p>
         <ul>
             <li><a href="#view-schedule">View Weekly Schedule</a></li>
             <li><a href="#upcoming-sessions">Upcoming Sessions</a></li>
         </ul>
     </section>
     <section id="my-grades">
         <h3>My Grades</h3>
         <p>View your grades and performance reports.</p>
         <ul>
             <li><a href="#view-grades">View Grades</a></li>
             <li><a href="#performance-reports">Performance Reports</a></li>
             <li><a href="#participation-data">Participation Data</a></li>
         </ul>
     </section>
     <section id="settings">
         <h3>Settings</h3>
         <p>Manage your account settings and preferences.</p>
         <ul>
             <li><a href="#account-settings">Account Settings</a></li>
             <li><a href="#notification-preferences">Notification Preferences</a></li>
             <li><a href="logout.php">Log Out</a></li>
         </ul>
     </section>
<!-- Footer -->
  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>
</body>
</html>