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
    <link rel="icon" type="image/png" href="../assets/img/icon.png">
    <title>Login - Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'skyblue': '#87CEEB',
                        'bluegreen': '#20B2AA'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #87CEEB 0%, #20B2AA 100%);
        }
        
        /* Loading overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #20B2AA;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .loading-logo {
            font-size: 32px;
            font-weight: bold;
            color: #20B2AA;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center py-8">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner">
            <div class="loading-logo"><img src="../public/img/logo.png" alt=""></div>
        </div>
    </div>
    
    <div class="max-w-md w-full mx-auto px-6">
        <!-- Back to Home Button -->
        <div class="mb-6">
            <button id="backHome" class="bg-white/20 backdrop-blur-sm text-white px-6 py-2 rounded-lg hover:bg-white/30 transition-colors" onclick="window.location.href='./';">
                ← Back to Home
            </button>
        </div>
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="../public/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
                <span class="ml-3 text-2xl font-bold text-white">Attendance System</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
            <p class="text-white/80">Sign in to your attendance account</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form id="login" class="space-y-6">
                <!-- ID Number -->
                <div>
                    <label for="idNumber" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="text" id="idNumber" name="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                           placeholder="Enter your Email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                               placeholder="Enter your password">
                                <input type="hidden" name="action" value="login">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="eyeIcon" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="#" id="forgotPassword" class="text-bluegreen font-medium hover:underline">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="hidden bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                </div>

                <!-- Success Message -->
                <div id="successMessage" class="hidden bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitButton"
                        class="w-full bg-gradient-to-r from-skyblue to-bluegreen text-white py-3 px-6 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    Sign In
                </button>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600">Don't have an account? 
                        <a href="signup" id="registerLink" class="text-bluegreen font-medium hover:underline">Create one here</a>
                    </p>
                </div>

                <!-- Continue with Google -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>
                    
                    <button type="button" id="googleSignIn" 
                            class="mt-4 w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continue with Google
                    </button>
                </div>
            </form>
        </div>
    </div>

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
        // Loading overlay functions
        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.add('active');
        }
        
        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.remove('active');
        }
        
        // Google Sign In handler with loading
        document.getElementById('googleSignIn').addEventListener('click', function() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                alert('Google Sign-In would redirect to Google OAuth here. This would allow users to sign in using their Google account.');
            }, 500);
        });

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading
            showLoading();
            
            setTimeout(() => {
                // Get form data
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                
                // Hide previous messages
                document.getElementById('errorMessage').classList.add('hidden');
                document.getElementById('successMessage').classList.add('hidden');
                
                // Validation
                let errors = [];
                
                // Check required fields
                if (!data.idNumber.trim()) {
                    errors.push('ID Number is required');
                }
                if (!data.password) {
                    errors.push('Password is required');
                }
                
                // ID Number validation (basic)
                if (data.idNumber && data.idNumber.length < 4) {
                    errors.push('ID Number must be at least 4 characters');
                }
                
                // Password validation (basic)
                if (data.password && data.password.length < 6) {
                    errors.push('Password must be at least 6 characters');
                }
                
                if (errors.length > 0) {
                    const errorDiv = document.getElementById('errorMessage');
                    errorDiv.innerHTML = errors.join('<br>');
                    errorDiv.classList.remove('hidden');
                    hideLoading();
                    return;
                }
                
                // Simulate login process
                const successDiv = document.getElementById('successMessage');
                successDiv.innerHTML = `Login successful! Welcome back, ${data.idNumber}. Redirecting to dashboard...`;
                successDiv.classList.remove('hidden');
                
                // Hide loading
                hideLoading();
                
                // Simulate redirect after 2 seconds
                setTimeout(() => {
                    showLoading();
                    setTimeout(() => {
                        hideLoading();
                        alert('Redirecting to attendance dashboard...');
                        // In a real app, you would redirect to the dashboard
                        // window.location.href = '/dashboard';
                    }, 500);
                }, 2000);
            }, 500); // 0.5 second delay
        });

        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"/><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>';
            }
        });

        // Forgot password handler with loading
        document.getElementById('forgotPassword').addEventListener('click', function(e) {
            e.preventDefault();
            showLoading();
            setTimeout(() => {
                hideLoading();
                alert('Password reset functionality would be implemented here. Please contact your administrator for password reset.');
            }, 500);
        });

        // Auto-focus on ID number field
        document.getElementById('idNumber').focus();



        

    </script>
</body>
</html>
