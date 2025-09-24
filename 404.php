<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/img/icon.png">
    <title>404 - Page Not Found | Attendance System</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #87CEEB 0%, #20B2AA 100%);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        .floating-animation-delayed {
            animation: float 6s ease-in-out infinite;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(135, 206, 235, 0.3); }
            to { box-shadow: 0 0 40px rgba(135, 206, 235, 0.6); }
        }

        .bounce-in {
            animation: bounce-in 1s ease-out;
        }

        @keyframes bounce-in {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-animation absolute top-20 left-10 w-16 h-16 bg-white/10 rounded-full"></div>
        <div class="floating-animation-delayed absolute top-40 right-20 w-12 h-12 bg-white/15 rounded-full"></div>
        <div class="floating-animation absolute bottom-32 left-1/4 w-8 h-8 bg-white/20 rounded-full"></div>
        <div class="floating-animation-delayed absolute bottom-20 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>
        <div class="floating-animation absolute top-1/3 left-1/2 w-6 h-6 bg-white/25 rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-8 bounce-in">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="/Attendance_CB/assets/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
            <span class="ml-4 text-3xl font-bold text-white">Attendance System</span>
        </div>

        <!-- 404 Number -->
        <div class="mb-8 bounce-in" style="animation-delay: 0.2s;">
            <h1 class="text-9xl md:text-[12rem] font-extrabold text-white/20 leading-none select-none">
                404
            </h1>
            <div class="relative -mt-16 md:-mt-24">
                <h2 class="text-4xl md:text-6xl font-bold text-white mb-4">
                    Oops! Page Not Found
                </h2>
            </div>
        </div>

        <!-- Error Message -->
        <div class="mb-12 bounce-in" style="animation-delay: 0.4s;">
            <p class="text-xl md:text-2xl text-white/90 mb-6 max-w-2xl mx-auto leading-relaxed">
                The page you're looking for seems to have wandered off into the digital void. 
                Don't worry, even the best attendance systems sometimes lose track of things!
            </p>
            <p class="text-lg text-white/70 max-w-xl mx-auto">
                Let's get you back on track to where you need to be.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center items-center mb-12 bounce-in" style="animation-delay: 0.6s;">
            <button id="goHome" 
                    class="bg-white text-bluegreen px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg" onclick="window.location.href='./';">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Go Home
            </button>
        </div>



        <!-- Footer -->
        <div class="mt-12 text-white/60 bounce-in" style="animation-delay: 1s;">
            <p class="text-sm">
                If you believe this is an error, please contact our support team.
            </p>
            <p class="text-xs mt-2">
                Error Code: 404 | Attendance System
            </p>
        </div>
    </div>

    <script>
        // // Go Home button
        // document.getElementById('goHome').addEventListener('click', function() {
        //     // In a real application, this would navigate to the home page
        //     alert('Redirecting to home page...');
        //     // window.location.href = '/';
        // });





        // Add some interactive effects
        document.addEventListener('mousemove', function(e) {
            const cursor = { x: e.clientX, y: e.clientY };
            const floatingElements = document.querySelectorAll('.floating-animation, .floating-animation-delayed');
            
            floatingElements.forEach((element, index) => {
                const rect = element.getBoundingClientRect();
                const elementCenter = {
                    x: rect.left + rect.width / 2,
                    y: rect.top + rect.height / 2
                };
                
                const distance = Math.sqrt(
                    Math.pow(cursor.x - elementCenter.x, 2) + 
                    Math.pow(cursor.y - elementCenter.y, 2)
                );
                
                if (distance < 100) {
                    const angle = Math.atan2(cursor.y - elementCenter.y, cursor.x - elementCenter.x);
                    const force = (100 - distance) / 100;
                    const moveX = Math.cos(angle) * force * 10;
                    const moveY = Math.sin(angle) * force * 10;
                    
                    element.style.transform = `translate(${-moveX}px, ${-moveY}px)`;
                } else {
                    element.style.transform = 'translate(0px, 0px)';
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                document.getElementById('goHome').click();
            }
        });

        // Auto-focus for accessibility
        document.getElementById('goHome').focus();
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'97a47203356e9896',t:'MTc1NzA2MTg3My4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
