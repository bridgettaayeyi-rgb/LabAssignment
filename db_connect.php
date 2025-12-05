<?php
$servername = "localhost";
$username = "bridgetta.akoto";
$password = "Bri&moo000";
$dbname = "webtech_2025A_bridgetta_akoto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
