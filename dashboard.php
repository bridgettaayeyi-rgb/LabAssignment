<?php
session_start();
require "auth_check.php"; // ensures user is logged in

// Safety check: role must exist
if (!isset($_SESSION['role'])) {
    // No role? force logout to avoid errors
    header("Location: logout.php");
    exit;
}

$role = $_SESSION['role'];

switch ($role) {
    case "faculty":
        header("Location: facultydashboard.php");
        break;

    case "student":
        header("Location: studentdashboard.php");
        break;

    case "intern":
        header("Location: interndashboard.php");
        break;

    default:
        // Unknown role → logout as security measure
        header("Location: logout.php");
        break;
}

exit;
