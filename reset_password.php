<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Attendance Management Portal</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      width: 120px;
      position: absolute;
      top: 25px;
      right: 40px;
    }

    form {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px 50px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      text-align: center;
      width: 350px;
    }

    h2 {
      margin-bottom: 15px;
    }

    p {
      font-size: 15px;
      margin-bottom: 25px;
    }

    label {
      display: block;
      text-align: left;
      font-size: 16px;
      margin-bottom: 8px;
    }

    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 10px;
      font-size: 15px;
    }

    input:focus {
      outline: 2px solid #990000;
      background-color: #fefefe;
    }

    button {
      background-color: white;
      color: #660000;
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

    button:hover {
      background-color: #440000;
      color: white;
      transform: scale(1.05);
    }

    .error {
      color: #ff9e9e;
      font-size: 0.9em;
      margin-bottom: 10px;
      text-align: left;
    }

    a {
      color: #ffd9d9;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
    }

    a:hover {
      color: #ffffff;
      text-decoration: underline;
    }

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
    }
  </style>
</head>

<body>
  <img src="ashesilogo.png" alt="Ashesi University Logo" class="logo">

  <form id="resetForm">
    <h2>Reset Password</h2>
    <p>Enter your new password below.</p>

    <label for="newPassword">New Password:</label>
    <input type="password" id="newPassword" name="newPassword" required>
    <div id="newPasswordError" class="error"></div>

    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required>
    <div id="confirmPasswordError" class="error"></div>

    <button type="submit">Update Password</button>
  </form>

  <a href="Login.php">Back to Login</a>

  <script>
    document.getElementById("resetForm").addEventListener("submit", function(e) {
      e.preventDefault();

      // Clear previous errors
      document.getElementById("newPasswordError").textContent = "";
      document.getElementById("confirmPasswordError").textContent = "";

      const newPassword = document.getElementById("newPassword").value.trim();
      const confirmPassword = document.getElementById("confirmPassword").value.trim();

      let valid = true;

      // Strong password regex
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

      if (!passwordRegex.test(newPassword)) {
        document.getElementById("newPasswordError").textContent =
          "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
        valid = false;
      }

      if (newPassword !== confirmPassword) {
        document.getElementById("confirmPasswordError").textContent = "Passwords do not match.";
        valid = false;
      }

      if (valid) {
        Swal.fire({
          icon: "success",
          title: "Password Reset Successful!",
          text: "You can now log in with your new password.",
          confirmButtonColor: "#440000"
        }).then(() => {
          window.location.href = "login.html";
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Invalid Input!",
          text: "Please fix the highlighted errors before proceeding.",
          confirmButtonColor: "#990000"
        });
      }
    });
  </script>

  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>
</body>
</html>
