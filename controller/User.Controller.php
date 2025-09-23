<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
include "../auth/db.php";
include "../model/User.Model.php";
include "../vendor/autoload.php";


use Ulid\Ulid;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = "supersecretkey";



// If already logged in, redirect to dashboard
if (isset($_SESSION['jwt'])) {
    header("Location: dashboard");
    exit;
}


if($_SERVER["REQUEST_METHOD"] === "POST"){
 
       try{

        $action = $_POST['action'];
         $user = new User($conn);



        switch($action){
            case "login":


                         $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $password = $_POST["password"];
                   $userData = $user->login($email,$password);

            if($userData){

                //    Create JWT token
                $payload = [
                    'iat' => time(),
                    'exp' => time() + (60 * 60 * 24 * 7), // 7 days
                    'user_id' => $userData['id'],
                    'email' => $userData['email'],
                    'role' => $userData['role']
                ];

                $jwt = JWT::encode($payload, $secret_key, 'HS256');

                // Store in session and cookie
                $_SESSION['jwt'] = $jwt;
                setcookie("auth_token", $jwt, [
                    'expires' => time() + (60 * 60 * 24 * 7),
                    'path' => '/',
                    'secure' => false,  // true if HTTPS
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);


              switch ($userData["role"]) {
    case "admin":
        $redirect = "privatenexus";
        break;
    case "superadmin":
        $redirect = "overseer";
        break;
    case "student":
        $redirect = "dashboard";
        break;
    default:
        $redirect = "signin";
        break;
}


                echo json_encode(["status" => "success", "message" => "Login Successful.", "redirect" => $redirect]);
               
            }else{
                 echo json_encode(["status" => "error", "message" => "Invalid Credentials."]);
                 exit();
            }

                break;
                case "register":
                    

            $id = Ulid::generate(true);
            $idnumber = $_POST["idnumber"];
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            $fname = $_POST["fname"];
            $mname = $_POST["mname"];
            $lname = $_POST["lname"];
            $year = $_POST["year"];
            $course = $_POST["course"];
            $password = $_POST["password"];
            $confirmpass = $_POST["confirmpass"];



          if ($user->CheckUser($email, $idnumber)) {
    echo json_encode(["status" => "error", "message" => "User Already Exist."]);
    exit();
} else {
    if ($password !== $confirmpass) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        exit();
    } else {
       
        $registerUser = $user->register(
            $id,
            $idnumber,
            $email,
            $fname,
            $mname,
            $lname,
            $year,
            $course,
            $password
        );

        if ($registerUser) {
            echo json_encode(["status" => "success", "message" => "Register Successfully."]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Registration Failed."]);
            exit();
        }
    }
}


                    break;

                default:

                break;
        }

         
    }catch(Exception $e){
        error_log("Error: ". $e->getMessage());
        echo json_encode(["status" => "error", "message" => "An unexpected error occured."]);
        exit();
    }





      


}