<?php
session_start();

// Remove session JWT
unset($_SESSION['jwt']);

// Destroy the session
session_destroy();

// Clear the auth cookie
setcookie("auth_token", "", time() - 3600, "/", "", false, true);

// Redirect to signin page
header("Location: signin");
exit;
