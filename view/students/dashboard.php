<?php
session_start();
require "../../vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = "supersecretkey";

if(!isset($_SESSION['jwt'] ) && !isset($_COOKIE['auth_token'])){
    header("Location: signin");
    exit;

}

$token = $_SESSION['jwt'] ?? $_COOKIE['auth_token'];

try{
    $decode = JWT::decode($token, new Key($secret_key, 'HS256'));
    $email = htmlspecialchars($decode->email);

} catch(Exception $e){
    session_destroy();
    setcookie("auth_token", "", time() - 3600, "/");
    header("Location: signin");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashbaord</title>
</head>
<body>
    <h1>Welcome Here User </h1>
    <a href="logout">Logout</a>

</body>
</html>