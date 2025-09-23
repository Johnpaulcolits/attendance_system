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
    $role = htmlspecialchars($decode->role);

    if($role === "admin"){
        header("Location: privatenexus");
        exit();
    }else if($role === "superadmin"){
  header("Location: overseer");
   exit();
    }

    


} catch(Exception $e){
    session_destroy();
    setcookie("auth_token", "", time() - 3600, "/");
    header("Location: signin");
}
?>