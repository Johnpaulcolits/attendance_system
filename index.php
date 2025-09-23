<?php
session_start();

require "./vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "supersecretkey";

if (isset($_SESSION['jwt']) || isset($_COOKIE['auth_token'])) {
    $token = $_SESSION['jwt'] ?? $_COOKIE['auth_token'];
    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        // Optionally: redirect straight to dashboard
        header("Location: dashboard");
        exit;
    } catch (Exception $e) {
        session_destroy();
        setcookie("auth_token", "", time() - 3600, "/");
        header("Location: signin"); // uncomment if you want auto-redirect
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
</head>
<body>
    
This is the Landing Page. <a href="signup">Click Here!</a>


</body>
</html> 