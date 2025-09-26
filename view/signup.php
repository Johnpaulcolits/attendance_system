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
    <title>Register - Codebyters Attendance System</title>
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

        
        .popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(135, 206, 235, 0.3);
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  z-index: 9999;
}

.popup-content {
  background: linear-gradient(135deg, #87CEEB 0%, #20B2AA 100%);
  color: #fff;
  padding: 20px 30px;
  border-radius: 8px;
  text-align: center;
  max-width: 350px;
  width: 100%;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.check-icon {
  font-size: 40px;
  color: #4CAF50;
  margin-bottom: 10px;
}

.popup.active {
  opacity: 1;
  visibility: visible;
}


.error-icon {
  color: #F44336; /* red for error */
}

    </style>
</head>
<body class="gradient-bg min-h-screen py-8">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner">
            <div class="loading-logo">AS</div>
        </div>
    </div>
    
    <div class="max-w-2xl mx-auto px-6">
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
                    <img src="../assets/img/logo.png" alt="Codebyters Logo" class="w-10 h-10 rounded-lg object-cover" />
                </div>
                <span class="ml-3 text-2xl font-bold text-white">Codebyters</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Create Your Account</h1>
            <p class="text-white/80">Join the smart attendance system</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form id="registrationForm" class="space-y-6" method="POST" >
                <!-- ID Number -->
                <!-- Error Message -->
                <div id="errorMessage" class="hidden bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                </div>

                <!-- Success Message -->
                <div id="successMessage" class="hidden bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                </div>

                <!-- Submit Button -->
                <div>
                    <label for="idNumber" class="block text-sm font-medium text-gray-700 mb-2">ID Number</label>
                    <input type="text" id="idNumber" name="idnumber" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                           placeholder="Enter your student ID">
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                           placeholder="Enter your email address">
                </div>

                <!-- Name Fields -->
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" id="firstName" name="fname" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                               placeholder="First name">
                    </div>
                    <div>
                        <label for="middleInitial" class="block text-sm font-medium text-gray-700 mb-2">Middle Initial</label>
                        <input type="text" id="middleInitial" name="mname" maxlength="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors text-center"
                               placeholder="M">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" id="lastName" name="lname" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                               placeholder="Last name">
                    </div>
                </div>
                 <div id="popup" class="popup">
                <div class="popup-content">
                 <div id="popupIcon" class="check-icon">✔</div>
                  <p id="popupMessage"></p>
              </div>
                    </div>


                <!-- Section and Year Level -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 mb-2">Section</label>
                        <select id="section" name="course" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors">
                                 <option value="">Select Option</option>
                                <option value="BSIT">BSIT</option>
                                <option value="BITM">BITM</option>
                                <option value="BSM">BSM</option>
                                <option value="BSCE">BSCE</option>

                        </select>
                    </div>
                    <div>
                        <label for="yearLevel" class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                        <select id="yearLevel" name="year" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors">
                            <option value="">Select year level</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                            <option value="5th">5th</option>
                        </select>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                                   placeholder="Create a password">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIcon" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Password Requirements -->
                        <div id="passwordRequirements" class="mt-3 p-3 bg-gray-50 rounded-lg hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Password Requirements:</p>
                            <div class="space-y-1 text-sm">
                                <div id="req-length" class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    At least 8 characters
                                </div>
                                <div id="req-uppercase" class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    One uppercase letter (A-Z)
                                </div>
                                <div id="req-lowercase" class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    One lowercase letter (a-z)
                                </div>
                                <div id="req-number" class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    One number (0-9)
                                </div>
                                <div id="req-special" class="flex items-center text-red-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    One special character (!@#$%^&*)
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <div class="relative">
                            <input type="password" id="confirmPassword" name="confirmpass" required
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent transition-colors"
                                   placeholder="Confirm your password">
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eyeIconConfirm" class="w-5 h-5 text-gray-400 hover:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                            
                                        <input type="hidden" name="action" value="register">

                <button type="submit" id="submitButton"
                        class="w-full bg-gradient-to-r from-skyblue to-bluegreen text-white py-3 px-6 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600">Already have an account? 
                        <a href="signin" class="text-bluegreen font-medium hover:underline">Sign in here</a>
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
                    
                    <button type="button" id="googleSignUp" 
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

        document.getElementById("registrationForm").addEventListener("submit", function(e) {
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
        // alert(data.message);
        showPopup(data.message, data.status);

        if (data.status === "success") {
            setTimeout(() => {
                showLoading();
                setTimeout(() => {
                    window.location.href = "signin";
                }, 2000);
            }, 2000);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        // alert("Something Went Wrong.");
        showPopup("Something went wrong. Please try again.", true);
    });
});

function showPopup(message, type = "success") {
  const popup = document.getElementById("popup");
  const popupMessage = document.getElementById("popupMessage");
  const popupIcon = document.getElementById("popupIcon");

  popupMessage.textContent = message;

  // Set icon + color based on type
  if (type === "success") {
    popupIcon.textContent = "✔";
    popupIcon.className = "check-icon";
  } else if (type === "error") {
    popupIcon.textContent = "✖";
    popupIcon.className = "check-icon error-icon";
  }

  popup.classList.add("active");

  // Auto-hide after 2s
  setTimeout(() => {
    popup.classList.remove("active");
  }, 2000);
}



        // Loading overlay functions
        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.add('active');
        }
        
        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.remove('active');
        }
        
        // Google Sign Up handler with loading
        document.getElementById('googleSignUp').addEventListener('click', function() {
            showLoading();
            setTimeout(() => {
                hideLoading();
                alert('Google Sign-Up would redirect to Google OAuth here. This would allow users to sign up using their Google account and auto-fill some information.');
            }, 500);
        });

// document.getElementById("registrationForm").addEventListener("submit", function(e) {
//     e.preventDefault();

//     const form = e.target;
//     const formData = new FormData(form);

//     // Show loading
//     showLoading();

//     fetch("../controller/Controller.User.php", {
//         method: "POST",
//         body: formData
//     })
//     .then(response => response.json())
//     .then(data => {
//         // Keep loading for at least 0.5s
//         setTimeout(() => {
//             hideLoading();
//             console.log("Server Response:", data);

//             if (data.status === "success") {
//                 document.getElementById("successMessage").innerText = data.message;
//                 document.getElementById("successMessage").classList.remove("hidden");
//                 document.getElementById("errorMessage").classList.add("hidden");
//             } else {
//                 document.getElementById("errorMessage").innerText = data.message;
//                 document.getElementById("errorMessage").classList.remove("hidden");
//                 document.getElementById("successMessage").classList.add("hidden");
//             }
//         }, 500); // 0.5s delay
//     })
//     .catch(error => {
//         setTimeout(() => {
//             hideLoading();
//             console.error("Error:", error);
//             alert("An error occurred while processing your request.");
//         }, 500);
//     });
// });

    

        // Password requirements validation
        document.getElementById('password').addEventListener('focus', function() {
            document.getElementById('passwordRequirements').classList.remove('hidden');
        });

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            
            // Check each requirement
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*]/.test(password)
            };
            
            // Update each requirement display
            updateRequirement('req-length', requirements.length);
            updateRequirement('req-uppercase', requirements.uppercase);
            updateRequirement('req-lowercase', requirements.lowercase);
            updateRequirement('req-number', requirements.number);
            updateRequirement('req-special', requirements.special);
        });

        function updateRequirement(elementId, isValid) {
            const element = document.getElementById(elementId);
            const svg = element.querySelector('svg');
            
            if (isValid) {
                element.className = 'flex items-center text-green-600';
                svg.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>';
            } else {
                element.className = 'flex items-center text-red-600';
                svg.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>';
            }
        }

        // Real-time password match validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#d1d5db';
            }
        });

        // Middle initial auto-uppercase
        document.getElementById('middleInitial').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
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

        // Confirm password visibility toggle
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');
            
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                eyeIconConfirm.innerHTML = '<path d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"/><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>';
            } else {
                confirmPasswordInput.type = 'password';
                eyeIconConfirm.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"/>';
            }
        });


        
    </script>
</body>
</html>