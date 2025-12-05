
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up | Attendance Management Portal</title>

  <!-- Internal CSS -->
  <style>
    /* General Page Styling */
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
      padding: 40px 60px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      text-align: center;
      width: 380px;
    }

    /* Headline */
    h2 {
      margin-bottom: 25px;
      font-size: 28px;
      letter-spacing: 1px;
    }

    /* Labels */
    label {
      display: block;
      text-align: left;
      margin-bottom: 6px;
      font-size: 16px;
      letter-spacing: 0.4px;
    }

    /* Input Fields */
    input[type="text"],
    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      margin-bottom: 18px;
      font-size: 15px;
      font-family: "Times New Roman", Times, serif;
    }

    input[type="text"]:focus,
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="date"]:focus,
    input[type="password"]:focus {
      outline: 2px solid #990000;
      background-color: #fefefe;
    }

    /* Sign-Up Button */
    #signup-btn2 {
      background-color: white;
      color: #440000;
      border: none;
      padding: 12px 35px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 10px;
    }

    #signup-btn2:hover {
      background-color: #440000;
      color: white;
      transform: scale(1.05);
    }

    /* Links */
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

    /* Responsive Design */
    @media (max-width: 600px) {
      .logo {
        width: 90px;
        top: 10px;
        right: 20px;
      }

      form {
        width: 85%;
        padding: 30px;
      }

      h2 {
        font-size: 24px;
      }
    }
  </style>
</head>

<body>
  <!-- Ashesi Logo -->
  <img src="ashesilogo.png" alt="Ashesi University Logo" class="logo">

  <!-- Sign-Up Form -->
  <form id="signupForm">
    <h2>Sign Up</h2>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>
    
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <div id="emailError" class="error"></div>

    <label for="school-id">School ID:</label>
    <input type="text" id="school-id" name="school_id" required>
    <div id="idError" class="error"></div>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required>
    <div id="dobError" class="error"></div>

    <label for="role">Choose Your Role:</label>
    <select id="role" name="role" required>
        <option value="">Choose role</option>
        <option value="student">Student</option>
        <option value="faculty">Faculty</option>
        <option value="intern">Faculty Intern</option>
    </select>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <div id="passwordError" class="error"></div>

    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirmpassword" required>
    <div id="confirmError" class="error"></div>
    <input type="submit" id="signup-btn2" value="SIGN UP">
    

    <p>Already have an account? <a href="Login.php">Log In</a></p>
  </form>

  <!-- Validation -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
document.getElementById("signupForm").addEventListener("submit", async function(e) {
    e.preventDefault();
    document.querySelectorAll(".error").forEach(el => el.textContent = "");

    const first_name = document.getElementById("first_name").value.trim();
    const last_name = document.getElementById("last_name").value.trim();
    const email = document.getElementById("email").value.trim();
    const schoolId = document.getElementById("school-id").value.trim();
    const dob = document.getElementById("dob").value;
    const role = document.getElementById("role").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm-password").value;

    let valid = true;

    // First name validation
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(first_name)) {
        alert("First name should contain only letters and spaces.");
        valid = false;
    }

    // Last name validation
    if (!nameRegex.test(last_name)) {
        alert("Last name should contain only letters and spaces.");
        valid = false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("emailError").textContent = "Please enter a valid email address.";
        valid = false;
    }

    // School ID validation (8 digits)
    const idRegex = /^\d{8}$/;
    if (!idRegex.test(schoolId)) {
        document.getElementById("idError").textContent = "School ID must be exactly 8 digits.";
        valid = false;
    }

    // DOB validation
    if (!dob) {
        document.getElementById("dobError").textContent = "Please enter your date of birth.";
        valid = false;
    }

    // Role validation
    if (!role) {
        alert("Please select a role.");
        valid = false;
    }

    // Password validation
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
    if (!passwordRegex.test(password)) {
        document.getElementById("passwordError").textContent =
          "Password must be at least 8 characters, contain uppercase, lowercase, number, and special character.";
        valid = false;
    }

    // Confirm password match
    if (password !== confirmPassword) {
        document.getElementById("confirmError").textContent = "Passwords do not match.";
        valid = false;
    }

    if (!valid) {
        Swal.fire({
            icon: "error",
            title: "Oops!",
            text: "Please fix the highlighted errors before continuing."
        });
        return;
    }

    // Submit via fetch to backend PHP
    const response = await fetch("processSignup.php", {
        method: "POST",
        body: new FormData(document.getElementById("signupForm"))
    });

    const result = await response.json();

    if (result.success) {
        Swal.fire({
            icon: "success",
            title: "Sign-up successful!",
            text: "Welcome, " + first_name
        }).then(() => {
            window.location.href = result.redirect;
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Sign-up failed!",
            text: result.message
        });
    }
});
</script>


  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Ashesi University | Attendance Management System</p>
  </footer>
</body>
</html>
