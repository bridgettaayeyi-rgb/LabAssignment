<?php
session_start();

// BONUS: If user is already logged in, redirect them to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Attendance Management Portal</title>

  <!-- Internal CSS -->
  <style>
    /* General Page Style */
    body {
      margin: 0;
      padding: 0;
      background-color: #440000; /* Ashesi wine */
      font-family: "Times New Roman", Times, serif;
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    /* Ashesi Logo */
    .logo {
      width: 120px;
      position: absolute;
      top: 25px;
      right: 40px;
    }

    /* Form Container */
    form {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px 50px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      text-align: center;
      width: 300px;
    }

    /* Form Labels */
    label {
      display: block;
      text-align: left;
      margin-bottom: 6px;
      font-size: 16px;
      letter-spacing: 0.5px;
    }

    /* Input Fields */
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 20px;
      font-size: 15px;
      font-family: "Times New Roman", Times, serif;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: 2px solid #440000;
      background-color: #fefefe;
    }

    /* Login Button */
    #login-btn2 {
      background-color: white;
      color: #440000;
      border: none;
      padding: 12px 30px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 10px;
    }

    #login-btn2:hover {
      background-color: #440000;
      color: white;
      transform: scale(1.05);
    }

    /* Links and Paragraphs */
    a {
      color: #ffd9d9;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    a:hover {
      color: #ffffff;
      text-decoration: underline;
    }

    p {
      margin-top: 20px;
      font-size: 14px;
    }
    .error {
      color: white;
      font-size: 0.9em;
      margin-bottom: 10px;
      text-align: left;
    }

    /* Footer */
    footer {
      background-color: #440000;
      color: white;
      text-align: center;
      padding: 12px;
      font-size: 14px;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      letter-spacing: 0.5px;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .logo {
        width: 90px;
        top: 10px;
        right: 20px;
      }

      form {
        width: 80%;
        padding: 30px;
      }
    }
  </style>
</head>

<body>
  <!-- Ashesi Logo -->
  <img src="ashesilogo.png" alt="Ashesi University Logo" class="logo">

  <!-- Login Form -->
  <form id="loginForm">
    <h2> Login</h2>
    <label for="user_id">Username:</label>
    <input type="text" id="user_id" name="user_id" required>
    <div id="usernameError" class="error"></div>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <div id="passwordError" class="error"></div>
    <input type="submit" id="login-btn2" value="LOG IN">

    <a href="forgotpassword.php">Forgot Password?</a>
    <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
  </form>

  <!-- Validation -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    document.querySelectorAll(".error").forEach(el => el.textContent = "");

    const user_id = document.getElementById("user_id").value.trim();  
    const password = document.getElementById("password").value.trim();

    let valid = true;

    
    const userIDRegex = /^[0-9]+$/;
    if (!userIDRegex.test(user_id)) {
        document.getElementById("usernameError").textContent = "User ID must contain numbers only.";
        valid = false;
    }

    if (password.length < 8) {
        document.getElementById("passwordError").textContent = "Password must be at least 8 characters.";
        valid = false;
    }

    if (!valid) {
        Swal.fire({
            icon: "error",
            title: "Invalid Input",
            text: "Please fix the highlighted errors.",
        });
        return;
    }

    // SEND DATA TO BACKEND
    const response = await fetch("processLogin.php", {
        method: "POST",
        body: new FormData(document.getElementById("loginForm"))
    });

    const result = await response.json();

    if (result.success) {
        Swal.fire({
            icon: "success",
            title: "Login successful!",
            text: "Welcome back, User " + result.first_name,
        }).then(() => {
            window.location.href = result.redirect;
        });

    } else {

        if (result.reason === "not_found") {
            Swal.fire({
                title: "Account Not Found",
                text: "No user with this ID exists. Would you like to create an account?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Go to Sign Up"
            }).then((action) => {
                if (action.isConfirmed) {
                    window.location.href = "signup.php";
                }
            });
        }

        else if (result.reason === "wrong_password") {
            Swal.fire({
                icon: "error",
                title: "Incorrect Password",
                text: "Please try again."
            });
        }

        else {
            Swal.fire({
                icon: "error",
                title: "Login Failed",
                text: "Invalid login credentials."
            });
        }
    }
});
</script>


  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>
</body>
</html>

