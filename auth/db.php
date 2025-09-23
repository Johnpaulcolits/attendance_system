<?php


// If already logged in, redirect to dashboard
if (isset($_SESSION['jwt'])) {
    header("Location: dashboard");
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$database  = "database";


$conn = new mysqli($host, $username, $password, $database);

if(!$conn){
    die("Connection failed" .mysqli_connect_error());
}