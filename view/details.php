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
    <link rel="icon" type="image/png" href="./assets/img/icon.png">
    <title>Learn More - Attendance System</title>
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

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="gradient-bg py-8">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="./public/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
                    <span class="ml-3 text-2xl font-bold text-white">Attendance System</span>
                </div>
                <button id="backHome" class="bg-white/20 backdrop-blur-sm text-white px-6 py-2 rounded-lg hover:bg-white/30 transition-colors" onclick="window.location.href='./';">
                    ← Back to Home
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-12">
        <!-- About Section -->
        <section class="mb-16 fade-in">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">About Attendance System</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Revolutionizing attendance management with smart, efficient, and user-friendly solutions 
                    designed for the modern educational environment.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        To streamline attendance tracking and management through innovative technology, 
                        making it easier for educational institutions to monitor student participation 
                        and engagement effectively.
                    </p>
                    <div class="flex items-center text-bluegreen font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        Smart & Efficient
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        To become the leading attendance management system that empowers educational 
                        institutions with real-time insights, automated processes, and seamless 
                        integration capabilities.
                    </p>
                    <div class="flex items-center text-bluegreen font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Future-Ready Solutions
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="mb-16 fade-in">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Key Features</h2>
                <p class="text-lg text-gray-600">Discover what makes our attendance system special</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Real-Time Tracking</h3>
                    <p class="text-gray-600">Monitor attendance instantly with live updates and notifications.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h4v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45-1.5a2.5 2.5 0 114.9 0 2.5 2.5 0 01-4.9 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Smart Reports</h3>
                    <p class="text-gray-600">Generate comprehensive attendance reports with detailed analytics.</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-skyblue to-bluegreen rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Secure Access</h3>
                    <p class="text-gray-600">Advanced security features to protect sensitive attendance data.</p>
                </div>
            </div>
        </section>

        <!-- Organization Structure -->
        <section class="mb-16 fade-in">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Organization Structure</h2>
                <p class="text-lg text-gray-600">Meet our dedicated team leading the Attendance System initiative</p>
            </div>

            <!-- President -->
            <div class="flex justify-center mb-8">
                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center max-w-sm">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="President Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5QcmVzaWRlbnQ8L3RleHQ+Cjwvc3ZnPg=='; this.alt='President - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">President</h3>
                    <p class="text-gray-600 text-sm">Leading the organization with vision and strategic direction</p>
                </div>
            </div>

            <!-- Vice President and Secretary -->
            <div class="grid md:grid-cols-2 gap-8 mb-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="Vice President Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5WUDwvdGV4dD4KPHN2Zz4='; this.alt='Vice President - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Vice President</h3>
                    <p class="text-gray-600 text-sm">Supporting leadership and overseeing key operations</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="Secretary Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5TZWM8L3RleHQ+Cjwvc3ZnPg=='; this.alt='Secretary - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Secretary</h3>
                    <p class="text-gray-600 text-sm">Managing documentation and organizational communications</p>
                </div>
            </div>

            <!-- Treasurer and Auditor -->
            <div class="grid md:grid-cols-2 gap-8 mb-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png"
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5UcmVhczwvdGV4dD4KPHN2Zz4='; this.alt='Treasurer - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Treasurer</h3>
                    <p class="text-gray-600 text-sm">Managing financial resources and budget planning</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="Auditor Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5BdWRpdG9yPC90ZXh0Pgo8L3N2Zz4='; this.alt='Auditor - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Auditor</h3>
                    <p class="text-gray-600 text-sm">Ensuring compliance and financial accountability</p>
                </div>
            </div>

            <!-- Business Manager and P.I.O -->
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="Business Manager Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5CdXNNZ3I8L3RleHQ+Cjwvc3ZnPg=='; this.alt='Business Manager - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Business Manager</h3>
                    <p class="text-gray-600 text-sm">Overseeing business operations and strategic partnerships</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg hover-lift text-center">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden border-4 border-gradient-to-r from-skyblue to-bluegreen">
                        <img src="./assets/img/colita.png" 
                             alt="P.I.O Photo" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTUwIiBoZWlnaHQ9IjE1MCIgdmlld0JveD0iMCAwIDE1MCAxNTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiBmaWxsPSIjODdDRUVCIi8+Cjx0ZXh0IHg9Ijc1IiB5PSI4MCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmaWxsPSIjRkZGRkZGIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5QSU88L3RleHQ+Cjwvc3ZnPg=='; this.alt='P.I.O - Image not available';">
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">P.I.O</h3>
                    <p class="text-gray-600 text-sm">Public Information Officer - Managing communications and outreach</p>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="fade-in">
            <div class="bg-gradient-to-r from-skyblue to-bluegreen rounded-2xl p-8 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                <p class="text-xl mb-6 opacity-90">
                    Join thousands of institutions already using our attendance system
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button id="getStarted" class="bg-white text-bluegreen px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors" onclick="window.location.href='./view/signup';">
                        Get Started Today
                    </button>
                    <button id="contactUs" class="bg-white/20 backdrop-blur-sm text-white border-2 border-white/30 px-8 py-3 rounded-lg font-semibold hover:bg-white/30 transition-colors" onclick="window.location.href='contact';">
                        Contact Us
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center mb-4">
                 <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="./public/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
                <span class="text-xl font-bold">Attendance System</span>
            </div>
            <p class="text-gray-400">© 2024 Attendance System Attendance System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // // Back to Home button
        // document.getElementById('backHome').addEventListener('click', function() {
        //     alert('Redirecting to home page...');
        //     // window.location.href = '/';
        // });

        // // Get Started button
        // document.getElementById('getStarted').addEventListener('click', function() {
        //     alert('Redirecting to registration page...');
        //     // window.location.href = '/register';
        // });

        // // Contact Us button
        // document.getElementById('contactUs').addEventListener('click', function() {
        //     alert('Opening contact form...');
        //     // window.location.href = '/contact';
        // });

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'97a495239603b493',t:'MTc1NzA2MzMxMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
