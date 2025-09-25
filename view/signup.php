<?php
session_start();

require "../vendor/autoload.php";
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
        <link rel="icon" type="image/png" href="./public/img/logo.png">
    <title>Sign Up</title>
</head>
<body>
    <form id="registration">
    <label>Student ID: </label> 
    <input type="text" name="idnumber" id="student_id" required><br>

    <label>Email Address</label>
    <input type="email" name="email" id="email" required><br>

    <label>Firstname</label>
    <input type="text" name="fname" id="fname" required><br>

    <label>Middle Name</label>
    <input type="text" name="mname" id="mname" maxlength="1"><br>

    <label>Last Name</label>
    <input type="text" name="lname" id="lname" required><br>

    <label>Course</label>
    <select name="course" id="course" required> 
        <option value="">Select Option</option>
        <option value="BSIT">BSIT</option>
        <option value="BITM">BITM</option>
        <option value="BSM">BSM</option>
        <option value="BSCE">BSCE</option>
    </select><br>

    <label>Year Level</label>
    <select name="year" id="year" required>
        <option value="">Select Option</option>
        <option value="1st">1st</option>
        <option value="2nd">2nd</option>
        <option value="3rd">3rd</option>
        <option value="4th">4th</option>
    </select><br>

    <label>Password</label>  
    <input type="password" name="password" id="password" required><br>

    <label>Confirm Password</label>
    <input type="password" name="confirmpass" id="confirmpass" required><br>

      <input type="hidden" name="action" value="register">

    <input type="submit" value="Sign Up">
</form>

<script>




document.getElementById("registration").addEventListener("submit", function(e){
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("User.Controller", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server Response:", data);
        alert(data.message);
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something Went Wrong.");
    });
});
</script>

</body>
</html>