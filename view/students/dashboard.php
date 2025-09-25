<?php
include "../../auth/auth_student.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
        
        /* QR Code Modal Styles */
        .qr-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .qr-modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .qr-modal-content {
            background-color: white;
            border-radius: 16px;
            padding: 24px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .qr-modal.active .qr-modal-content {
            transform: scale(1);
        }
        
        /* Bottom Navigation Styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: white;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 40;
            padding: 8px 0;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-around;
            max-width: 28rem;
            margin: 0 auto;
        }
        
        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
            min-width: 60px;
        }
        
        .nav-btn:hover {
            background-color: #f9fafb;
        }
        
        .nav-btn:active {
            background-color: #f3f4f6;
        }
        
        .nav-icon {
            font-size: 24px;
            margin-bottom: 4px;
        }
        
        .nav-label {
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
        }
        
        /* Active state for navigation */
        .nav-btn.active .nav-icon,
        .nav-btn.active .nav-label {
            color: #20B2AA;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner">
            <div class="loading-logo">AS</div>
        </div>
    </div>
    
    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-bluegreen font-bold text-xl">AS</span>
                    </div>
                    <div>
                        <h1 class="text-white text-2xl font-bold">Attendance System</h1>
                        <p class="text-white/80 text-sm">Student Dashboard</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-white font-semibold"><?php echo $fname ." ". $lname ?></p>
                        <p class="text-white/80 text-sm">Student ID: <?php echo $idnumber?></p>
                    </div>
                    <div class="relative">
                        <button id="profileButton" class="w-12 h-12 rounded-full overflow-hidden border-2 border-white/30 hover:border-white transition-colors focus:outline-none focus:ring-2 focus:ring-white/50">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="John Doe" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-white rounded-full flex items-center justify-center" style="display: none;">
                                <span class="text-bluegreen font-bold text-lg">JD</span>
                            </div>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible transform scale-95 transition-all duration-200 z-50">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-xs text-gray-500">CB2024001</p>
                                </div>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                                    <span class="text-base">👤</span>
                                    <span>View Profile</span>
                                </button>
                                <hr class="my-1">
                                <button id="logoutButton" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center space-x-2">
                                    <span class="text-base">🚪</span>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24"> <!-- Added pb-24 for bottom nav spacing -->
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Classes</p>
                        <p class="text-3xl font-bold text-gray-900">24</p>
                    </div>
                    <div class="w-12 h-12 bg-skyblue/20 rounded-lg flex items-center justify-center">
                        <span class="text-skyblue text-xl">📚</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Present</p>
                        <p class="text-3xl font-bold text-green-600">20</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-green-600 text-xl">✅</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Absent</p>
                        <p class="text-3xl font-bold text-red-600">4</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="text-red-600 text-xl">❌</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Attendance Rate</p>
                        <p class="text-3xl font-bold text-bluegreen">83%</p>
                    </div>
                    <div class="w-12 h-12 bg-bluegreen/20 rounded-lg flex items-center justify-center">
                        <span class="text-bluegreen text-xl">📊</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule & Recent Attendance -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Today's Schedule -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Today's Schedule</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-skyblue/10 rounded-lg border-l-4 border-skyblue">
                        <div>
                            <h3 class="font-semibold text-gray-900">Web Development</h3>
                            <p class="text-gray-600 text-sm">Room 101 • Prof. Smith</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-bluegreen">9:00 AM</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Present</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-bluegreen/10 rounded-lg border-l-4 border-bluegreen">
                        <div>
                            <h3 class="font-semibold text-gray-900">Database Systems</h3>
                            <p class="text-gray-600 text-sm">Room 205 • Prof. Johnson</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-bluegreen">11:00 AM</p>
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Upcoming</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                        <div>
                            <h3 class="font-semibold text-gray-900">Software Engineering</h3>
                            <p class="text-gray-600 text-sm">Room 301 • Prof. Davis</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-bluegreen">2:00 PM</p>
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Scheduled</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Recent Attendance</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium text-gray-900">Web Development</h3>
                            <p class="text-gray-600 text-sm">Dec 15, 2024</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium text-gray-900">Database Systems</h3>
                            <p class="text-gray-600 text-sm">Dec 14, 2024</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium text-gray-900">Software Engineering</h3>
                            <p class="text-gray-600 text-sm">Dec 13, 2024</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">Absent</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div>
                            <h3 class="font-medium text-gray-900">Web Development</h3>
                            <p class="text-gray-600 text-sm">Dec 12, 2024</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <h3 class="font-medium text-gray-900">Database Systems</h3>
                            <p class="text-gray-600 text-sm">Dec 11, 2024</p>
                        </div>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
           <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <button data-path="attendance" class="flex items-center justify-center space-x-3 p-4 gradient-bg text-white rounded-lg hover:opacity-90 transition-opacity">
        <span class="text-xl">📋</span>
        <span class="font-medium">View Full Attendance</span>
    </button>
    
    <button data-path="schedule" class="flex items-center justify-center space-x-3 p-4 bg-skyblue text-white rounded-lg hover:bg-skyblue/90 transition-colors">
        <span class="text-xl">📅</span>
        <span class="font-medium">Check Schedule</span>
    </button>
    
    <button data-path="report" class="flex items-center justify-center space-x-3 p-4 bg-bluegreen text-white rounded-lg hover:bg-bluegreen/90 transition-colors">
        <span class="text-xl">📊</span>
        <span class="font-medium">Generate Report</span>
    </button>
</div>

        </div>
    </main>

    <!-- QR Code Modal -->
    <div id="qrModal" class="qr-modal">
        <div class="qr-modal-content">
            <div class="text-center">
                <!-- Close Button -->
                <button id="closeQRModal" class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                    <span class="text-gray-600">✕</span>
                </button>
                
                <!-- Codebyters Logo -->
                <div class="mb-6">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold text-3xl">CB</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Codebyters</h2>
                    <p class="text-gray-600 text-sm">Student ID Card</p>
                </div>
                
                <!-- Student Profile Info -->
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <!-- Student Photo -->
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Student avatar illustration -->
                            <circle cx="30" cy="30" r="30" fill="url(#studentGradient)"/>
                            <!-- Face -->
                            <circle cx="30" cy="22" r="8" fill="#FDB4A6"/>
                            <!-- Hair -->
                            <path d="M22 18C22 14 25 12 30 12C35 12 38 14 38 18C38 16 36 14 30 14C24 14 22 16 22 18Z" fill="#8B4513"/>
                            <!-- Eyes -->
                            <circle cx="27" cy="20" r="1.5" fill="#333"/>
                            <circle cx="33" cy="20" r="1.5" fill="#333"/>
                            <!-- Smile -->
                            <path d="M26 25C28 27 32 27 34 25" stroke="#333" stroke-width="1" stroke-linecap="round" fill="none"/>
                            <!-- Body/Shirt -->
                            <path d="M18 45C18 38 22 35 30 35C38 35 42 38 42 45V60H18V45Z" fill="#4F46E5"/>
                            <!-- Collar -->
                            <path d="M25 35C27 37 33 37 35 35" stroke="#fff" stroke-width="2" fill="none"/>
                            
                            <defs>
                                <linearGradient id="studentGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#87CEEB"/>
                                    <stop offset="100%" style="stop-color:#20B2AA"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $email?></h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Year:</span> 3rd Year</p>
                        <p><span class="font-medium">Section:</span> Computer Science - A</p>
                        <p><span class="font-medium">Student ID:</span> CB2024001</p>
                    </div>
                </div>
                
                <!-- QR Code -->
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 mb-6">
                    <div class="w-48 h-48 mx-auto bg-white flex items-center justify-center">
                        <!-- QR Code SVG -->
                        <svg width="192" height="192" viewBox="0 0 192 192" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- QR Code pattern -->
                            <rect width="192" height="192" fill="white"/>
                            <!-- Corner squares -->
                            <rect x="8" y="8" width="56" height="56" fill="black"/>
                            <rect x="16" y="16" width="40" height="40" fill="white"/>
                            <rect x="24" y="24" width="24" height="24" fill="black"/>
                            
                            <rect x="128" y="8" width="56" height="56" fill="black"/>
                            <rect x="136" y="16" width="40" height="40" fill="white"/>
                            <rect x="144" y="24" width="24" height="24" fill="black"/>
                            
                            <rect x="8" y="128" width="56" height="56" fill="black"/>
                            <rect x="16" y="136" width="40" height="40" fill="white"/>
                            <rect x="24" y="144" width="24" height="24" fill="black"/>
                            
                            <!-- Data pattern -->
                            <rect x="72" y="8" width="8" height="8" fill="black"/>
                            <rect x="88" y="8" width="8" height="8" fill="black"/>
                            <rect x="104" y="8" width="8" height="8" fill="black"/>
                            <rect x="72" y="24" width="8" height="8" fill="black"/>
                            <rect x="96" y="24" width="8" height="8" fill="black"/>
                            <rect x="112" y="24" width="8" height="8" fill="black"/>
                            
                            <rect x="8" y="72" width="8" height="8" fill="black"/>
                            <rect x="24" y="72" width="8" height="8" fill="black"/>
                            <rect x="40" y="72" width="8" height="8" fill="black"/>
                            <rect x="56" y="72" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="40" width="8" height="8" fill="black"/>
                            <rect x="88" y="40" width="8" height="8" fill="black"/>
                            <rect x="104" y="40" width="8" height="8" fill="black"/>
                            <rect x="120" y="40" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="56" width="8" height="8" fill="black"/>
                            <rect x="96" y="56" width="8" height="8" fill="black"/>
                            <rect x="112" y="56" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="72" width="8" height="8" fill="black"/>
                            <rect x="88" y="72" width="8" height="8" fill="black"/>
                            <rect x="104" y="72" width="8" height-8" fill="black"/>
                            <rect x="120" y="72" width="8" height="8" fill="black"/>
                            
                            <rect x="136" y="72" width="8" height="8" fill="black"/>
                            <rect x="152" y="72" width="8" height="8" fill="black"/>
                            <rect x="168" y="72" width="8" height="8" fill="black"/>
                            <rect x="184" y="72" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="88" width="8" height="8" fill="black"/>
                            <rect x="96" y="88" width="8" height="8" fill="black"/>
                            <rect x="112" y="88" width="8" height="8" fill="black"/>
                            <rect x="136" y="88" width="8" height="8" fill="black"/>
                            <rect x="160" y="88" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="104" width="8" height="8" fill="black"/>
                            <rect x="88" y="104" width="8" height="8" fill="black"/>
                            <rect x="120" y="104" width="8" height="8" fill="black"/>
                            <rect x="144" y="104" width="8" height="8" fill="black"/>
                            <rect x="168" y="104" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="120" width="8" height="8" fill="black"/>
                            <rect x="96" y="120" width="8" height="8" fill="black"/>
                            <rect x="112" y="120" width="8" height="8" fill="black"/>
                            <rect x="128" y="120" width="8" height="8" fill="black"/>
                            <rect x="152" y="120" width="8" height="8" fill="black"/>
                            <rect x="176" y="120" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="136" width="8" height="8" fill="black"/>
                            <rect x="88" y="136" width="8" height="8" fill="black"/>
                            <rect x="104" y="136" width="8" height="8" fill="black"/>
                            <rect x="128" y="136" width="8" height="8" fill="black"/>
                            <rect x="144" y="136" width="8" height="8" fill="black"/>
                            <rect x="168" y="136" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="152" width="8" height="8" fill="black"/>
                            <rect x="96" y="152" width="8" height="8" fill="black"/>
                            <rect x="120" y="152" width="8" height="8" fill="black"/>
                            <rect x="136" y="152" width="8" height="8" fill="black"/>
                            <rect x="160" y="152" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="168" width="8" height="8" fill="black"/>
                            <rect x="88" y="168" width="8" height="8" fill="black"/>
                            <rect x="104" y="168" width="8" height="8" fill="black"/>
                            <rect x="128" y="168" width="8" height="8" fill="black"/>
                            <rect x="152" y="168" width="8" height="8" fill="black"/>
                            <rect x="176" y="168" width="8" height="8" fill="black"/>
                            
                            <rect x="72" y="184" width="8" height="8" fill="black"/>
                            <rect x="96" y="184" width="8" height="8" fill="black"/>
                            <rect x="112" y="184" width="8" height="8" fill="black"/>
                            <rect x="136" y="184" width="8" height="8" fill="black"/>
                            <rect x="168" y="184" width="8" height="8" fill="black"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Scan for attendance verification</p>
                </div>
                
                <!-- Download Button -->
                <button id="downloadQRBtn" class="w-full gradient-bg text-white py-3 rounded-xl font-semibold hover:opacity-90 transition-opacity flex items-center justify-center space-x-2">
                    <span>📥</span>
                    <span>Download QR Code</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="nav-container">
            <button id="homeBtn" class="nav-btn active">
                <div class="nav-icon">🏠</div>
                <span class="nav-label">Home</span>
            </button>
            
            <button id="qrBtn" class="nav-btn">
                <div class="nav-icon">📱</div>
                <span class="nav-label">QR Code</span>
            </button>
            
            <button id="profileBtn" class="nav-btn">
                <div class="nav-icon">👤</div>
                <span class="nav-label">Profile</span>
            </button>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Profile dropdown functionality
            const profileButton = document.getElementById('profileButton');
            const profileDropdown = document.getElementById('profileDropdown');
            const logoutButton = document.getElementById('logoutButton');
            
            // Toggle dropdown
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isVisible = profileDropdown.classList.contains('opacity-100');
                
                if (isVisible) {
                    // Hide dropdown
                    profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                    profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                } else {
                    // Show dropdown
                    profileDropdown.classList.remove('opacity-0', 'invisible', 'scale-95');
                    profileDropdown.classList.add('opacity-100', 'visible', 'scale-100');
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
            });
            
            // Prevent dropdown from closing when clicking inside it
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Logout functionality with full page loading
            logoutButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to logout?')) {
                    // Close the dropdown first
                    profileDropdown.classList.remove('opacity-100', 'visible', 'scale-100');
                    profileDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                    
                    showLoading();
                    
                    // Simulate logout process
                    setTimeout(() => {
                        hideLoading();
                        window.location.href="logout";
                    }, 2000);
                }
            });
            
            // Add click handlers for Quick Action buttons with full page loading
           const quickActionButtons = document.querySelectorAll('.grid button');

quickActionButtons.forEach(button => {
    button.addEventListener('click', function () {
        const actionName = this.querySelector('.font-medium').innerText;
        const path = this.dataset.path; // 👈 get path from button

        showLoading();

        setTimeout(() => {
            hideLoading();
            window.location.href = path; // 👈 redirect based on button
        }, 1000);
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
            
            // Simulate real-time updates
            const updateTime = () => {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                // You could update a time display here if needed
            };
            
            // Update every minute
            setInterval(updateTime, 60000);
            
            // Bottom navigation functionality
            const homeBtn = document.getElementById('homeBtn');
            const qrBtn = document.getElementById('qrBtn');
            const profileBtnBottom = document.getElementById('profileBtn');
            const navButtons = document.querySelectorAll('.nav-btn');
            
            homeBtn.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    // alert('You are already on the Home Dashboard!');
                    window.location.href="dashboard";
                }, 1000);
            });
            
            qrBtn.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showQRModal();
            });
            
            profileBtnBottom.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('Opening Profile Page... (This is a demo)');
                }, 500);
            });
            
            // QR Modal functionality
            const qrModal = document.getElementById('qrModal');
            const closeQRModal = document.getElementById('closeQRModal');
            const downloadQRBtn = document.getElementById('downloadQRBtn');
            
            function showQRModal() {
                qrModal.classList.add('active');
            }
            
            function hideQRModal() {
                qrModal.classList.remove('active');
            }
            
            closeQRModal.addEventListener('click', hideQRModal);
            
            // Close modal when clicking outside
            qrModal.addEventListener('click', function(e) {
                if (e.target === qrModal) {
                    hideQRModal();
                }
            });
            
            // Download QR Code functionality
            downloadQRBtn.addEventListener('click', function() {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('QR Code downloaded successfully! (This is a demo)');
                }, 500);
            });
        });
    </script>
</body>
</html>