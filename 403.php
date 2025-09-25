<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
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
        body {
            box-sizing: border-box;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #87CEEB 0%, #20B2AA 100%);
        }
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white rounded-3xl shadow-2xl p-12 max-w-md w-full mx-4 text-center">
        <!-- Lock Icon -->
        <div class="floating-animation mb-8">
            <svg class="w-24 h-24 mx-auto text-bluegreen" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
            </svg>
        </div>

        <!-- Error Code -->
        <div class="mb-6">
            <h1 class="text-6xl font-bold text-bluegreen mb-2 pulse-animation">403</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Access Denied</h2>
        </div>

        <!-- Error Message -->
        <div class="mb-8">
            <p class="text-gray-600 text-lg leading-relaxed">
                Sorry, you don't have permission to access this page. Please check your credentials or contact an administrator.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            <button onclick="window.history.back()" class="w-full bg-bluegreen hover:bg-opacity-90 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg" onclick="window.location.href='../';">
                Go Back
            </button>
        </div>

      
    </div>

    <!-- Background Decorative Elements -->
    <div class="fixed top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: 0.5s;"></div>
    <div class="fixed bottom-10 right-10 w-16 h-16 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: 1s;"></div>
    <div class="fixed top-1/2 left-5 w-12 h-12 bg-white bg-opacity-10 rounded-full floating-animation" style="animation-delay: 1.5s;"></div>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'984a96fbc2b88d08',t:'MTc1ODgwNDAyNC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
