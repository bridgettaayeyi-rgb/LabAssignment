<?php
session_start();

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

// Restrict role if required
if (isset($required_role)) {
    if (!isset($_SESSION['role'])) {
        header("Location: unauthorized.php");
        exit;
    }

    $userRole = $_SESSION['role'];

    // for multiple roles 
    if (is_array($required_role)) {
        if (!in_array($userRole, $required_role)) {
            header("Location: unauthorized.php");
            exit;
        }
    }
    // only one role is allowed
    else {
        if ($userRole !== $required_role) {
            header("Location: unauthorized.php");
            exit;
        }
    }
}

?>
