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
    <title>Sign in</title>
</head>
<body>
    <form id="login">
        <label for="Email">Email</label>
        <input type="email" name="email" placeholder="Enter Email" required><br>

        <label for="Password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required><br>
      

        <input type="hidden" name="action" value="login">

        <input type="submit" value="Signin">
    </form>

    <script>
      

        // ✅ Handle login fetch
        document.getElementById("login").addEventListener("submit", function(e){
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("User.Controller", { // absolute path safer
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Server Response:", data);
                alert(data.message);

                if(data.status === "success"){
                    // window.location.href = "dashboard";
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong. Please try again.");
            });
        });
    </script>
</body>
</html>
