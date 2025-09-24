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
    <link rel="icon" type="image/png" href="./assets/img/icon.png">
    <title>Attendance System</title>
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
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                        <img src="./public/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                    </div>
                    <span class="ml-3 text-xl font-semibold text-gray-800">Attendance System</span>
                </div>
                <button class="bg-gradient-to-r from-skyblue to-bluegreen text-white px-6 py-2 rounded-lg font-medium hover:opacity-90 transition-opacity " onclick="window.location.href='signin';">
                    Login
                    
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg py-20">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h1 class="text-5xl font-bold text-white mb-6">
                Smart Attendance System
            </h1>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Streamline your attendance tracking with our modern, reliable, and easy-to-use system designed for educational institutions.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
    class="bg-white text-bluegreen px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors"
    onclick="window.location.href='signup';"
>
    Get Started
</button>
                <button class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-bluegreen transition-colors" onclick="window.location.href='details';">
                    Learn More
                </button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Key Features</h2>
                <p class="text-gray-600">Everything you need for efficient attendance management</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Real-time Tracking</h3>
                    <p class="text-gray-600">Monitor attendance instantly with live updates and notifications.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Automated Reports</h3>
                    <p class="text-gray-600">Generate comprehensive reports automatically with custom formats.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Cloud Storage</h3>
                    <p class="text-gray-600">Secure cloud storage with automatic backups and easy access.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-8">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="./public/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
                <span class="ml-3 text-xl font-semibold text-white">Attendance System</span>
            </div>
            <p class="text-gray-400">&copy; 2024 Attendance System. All rights reserved.</p>
        </div>
    </footer>

   
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'97a420ecb7409896',t:'MTc1NzA1ODU1Mi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
