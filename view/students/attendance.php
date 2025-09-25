<?php

include "../../auth/auth_student.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Attendance Record - Codebyters</title>
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
        
        .activity-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .status-present {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        .status-absent {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .status-late {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        /* QR Code Modal Styles (from dashboard) */
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
        
        /* Bottom Navigation Styles (from dashboard) */
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
                    <button id="backButton" class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center text-white hover:bg-white/30 transition-colors">
                        <span class="text-xl">←</span>
                    </button>
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <span class="text-bluegreen font-bold text-xl">AS</span>
                    </div>
                    <div>
                        <h1 class="text-white text-2xl font-bold">Full Attendance Record</h1>
                        <p class="text-white/80 text-sm">Complete activity history</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-white font-semibold">John Doe</p>
                        <p class="text-white/80 text-sm">Student ID: CB2024001</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24"> <!-- Added pb-24 for bottom nav spacing -->
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Activities</p>
                        <p class="text-3xl font-bold text-gray-900">48</p>
                    </div>
                    <div class="w-12 h-12 bg-skyblue/20 rounded-lg flex items-center justify-center">
                        <span class="text-skyblue text-xl">📚</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Present</p>
                        <p class="text-3xl font-bold text-green-600">40</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="text-green-600 text-xl">✅</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Absent</p>
                        <p class="text-3xl font-bold text-red-600">6</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="text-red-600 text-xl">❌</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Late Arrivals</p>
                        <p class="text-3xl font-bold text-orange-600">2</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <span class="text-orange-600 text-xl">⏰</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent">
                        <option value="all">All Status</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                    <select id="subjectFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-bluegreen focus:border-transparent">
                        <option value="all">All Subjects</option>
                        <option value="web-dev">Web Development</option>
                        <option value="database">Database Systems</option>
                        <option value="software-eng">Software Engineering</option>
                        <option value="mobile-dev">Mobile Development</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button id="exportBtn" class="px-4 py-2 gradient-bg text-white rounded-lg hover:opacity-90 transition-opacity flex items-center space-x-2">
                        <span>📊</span>
                        <span>Export</span>
                    </button>
                    <button id="printBtn" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                        <span>🖨️</span>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Attendance Records -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Attendance History</h2>
                <p class="text-gray-600 text-sm">Detailed record of all activities and attendance</p>
            </div>
            
            <div id="attendanceList" class="divide-y divide-gray-200">
                <!-- Attendance Record 1 -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="present" data-subject="web-dev">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-present">
                            <span class="text-white">💻</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Web Development - React Fundamentals</h3>
                                    <p class="text-gray-600 text-sm mt-1">Introduction to React components, JSX syntax, and state management. Hands-on coding session with practical examples.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 101, Computer Lab A</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 15, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-600">🟢</span>
                                            <span>Time In: 9:00 AM</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-red-600">🔴</span>
                                            <span>Time Out: 11:30 AM</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Duration: 2h 30m</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 2 -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="present" data-subject="database">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-present">
                            <span class="text-white">🗄️</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Database Systems - SQL Advanced Queries</h3>
                                    <p class="text-gray-600 text-sm mt-1">Complex JOIN operations, subqueries, and database optimization techniques. Practice with real-world scenarios.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 205, Database Lab</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 14, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-600">🟢</span>
                                            <span>Time In: 11:00 AM</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-red-600">🔴</span>
                                            <span>Time Out: 1:00 PM</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Duration: 2h 0m</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 3 - Absent -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="absent" data-subject="software-eng">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-absent">
                            <span class="text-white">⚙️</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Software Engineering - Agile Methodology</h3>
                                    <p class="text-gray-600 text-sm mt-1">Scrum framework, sprint planning, and team collaboration techniques. Case study analysis and group discussions.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 301, Conference Hall</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 13, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">Absent</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-400">⚫</span>
                                            <span class="text-gray-400">No Time In</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-gray-400">⚫</span>
                                            <span class="text-gray-400">No Time Out</span>
                                        </div>
                                        <div class="text-xs text-red-500 mt-1">Missed Session</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 4 - Late -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="late" data-subject="mobile-dev">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-late">
                            <span class="text-white">📱</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Mobile Development - Flutter Basics</h3>
                                    <p class="text-gray-600 text-sm mt-1">Introduction to Flutter framework, Dart programming language, and mobile app development fundamentals.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 102, Mobile Lab</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 12, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 text-sm rounded-full font-medium">Late</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-orange-600">🟡</span>
                                            <span>Time In: 2:15 PM</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-red-600">🔴</span>
                                            <span>Time Out: 4:30 PM</span>
                                        </div>
                                        <div class="text-xs text-orange-500 mt-1">15 min late • Duration: 2h 15m</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 5 -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="present" data-subject="web-dev">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-present">
                            <span class="text-white">🎨</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Web Development - CSS Grid & Flexbox</h3>
                                    <p class="text-gray-600 text-sm mt-1">Advanced CSS layout techniques, responsive design principles, and modern web styling approaches.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 101, Computer Lab A</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 11, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-600">🟢</span>
                                            <span>Time In: 9:00 AM</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-red-600">🔴</span>
                                            <span>Time Out: 11:30 AM</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Duration: 2h 30m</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Record 6 -->
                <div class="p-6 hover:bg-gray-50 transition-colors attendance-record" data-status="present" data-subject="database">
                    <div class="flex items-start space-x-4">
                        <div class="activity-icon status-present">
                            <span class="text-white">🔍</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">Database Systems - Data Modeling</h3>
                                    <p class="text-gray-600 text-sm mt-1">Entity-relationship diagrams, normalization techniques, and database design best practices.</p>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <span>📍</span>
                                            <span>Room 205, Database Lab</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>December 10, 2024</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Present</span>
                                    <div class="mt-2 text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-green-600">🟢</span>
                                            <span>Time In: 11:00 AM</span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-red-600">🔴</span>
                                            <span>Time Out: 1:00 PM</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Duration: 2h 0m</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-8">
            <button id="loadMoreBtn" class="px-6 py-3 gradient-bg text-white rounded-lg hover:opacity-90 transition-opacity">
                Load More Records
            </button>
        </div>
    </main>

    <!-- QR Code Modal (from dashboard) -->
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
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">John Doe</h3>
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
                            <rect x="104" y="72" width="8" height="8" fill="black"/>
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

    <!-- Bottom Navigation (from dashboard) -->
    <div class="bottom-nav">
        <div class="nav-container">
            <button id="homeBtn" class="nav-btn">
                <div class="nav-icon">🏠</div>
                <span class="nav-label">Home</span>
            </button>
            
            <button id="qrBtn" class="nav-btn">
                <div class="nav-icon">📱</div>
                <span class="nav-label">QR Code</span>
            </button>
            
            <button id="profileBtn" class="nav-btn active">
                <div class="nav-icon">👤</div>
                <span class="nav-label">Profile</span>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backButton = document.getElementById('backButton');
            const statusFilter = document.getElementById('statusFilter');
            const subjectFilter = document.getElementById('subjectFilter');
            const exportBtn = document.getElementById('exportBtn');
            const printBtn = document.getElementById('printBtn');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const attendanceRecords = document.querySelectorAll('.attendance-record');

            // Back button functionality
            backButton.addEventListener('click', function() {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    // alert('Returning to dashboard... (This is a demo)');
                    window.location.href="dashboard";
                }, 1000);
            });

            // Filter functionality
            function filterRecords() {
                const statusValue = statusFilter.value;
                const subjectValue = subjectFilter.value;

                attendanceRecords.forEach(record => {
                    const recordStatus = record.getAttribute('data-status');
                    const recordSubject = record.getAttribute('data-subject');
                    
                    const statusMatch = statusValue === 'all' || recordStatus === statusValue;
                    const subjectMatch = subjectValue === 'all' || recordSubject === subjectValue;
                    
                    if (statusMatch && subjectMatch) {
                        record.style.display = 'block';
                    } else {
                        record.style.display = 'none';
                    }
                });
            }

            statusFilter.addEventListener('change', filterRecords);
            subjectFilter.addEventListener('change', filterRecords);

            // Export functionality
            exportBtn.addEventListener('click', function() {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('Attendance report exported successfully! (This is a demo)');
                }, 500);
            });

            // Print functionality
            printBtn.addEventListener('click', function() {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('Print dialog opened! (This is a demo)');
                }, 500);
            });

            // Load more functionality
            loadMoreBtn.addEventListener('click', function() {
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('More records loaded! (This is a demo)');
                }, 500);
            });

            // Bottom navigation functionality (from dashboard)
            const homeBtn = document.getElementById('homeBtn');
            const qrBtn = document.getElementById('qrBtn');
            const profileBtn = document.getElementById('profileBtn');
            const navButtons = document.querySelectorAll('.nav-btn');
            
            // Set active state for profile button since we're on the attendance page
            profileBtn.classList.add('active');
            
            homeBtn.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    // alert('Navigating to Home Dashboard... (This is a demo)');
                    window.location.href="dashboard";
                }, 1000);
            });
            
            qrBtn.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showQRModal();
            });
            
            profileBtn.addEventListener('click', function() {
                // Set active state
                navButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                showLoading();
                setTimeout(() => {
                    hideLoading();
                    alert('Opening Profile Page... (This is a demo)');
                }, 500);
            });

            // QR Modal functionality (from dashboard)
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

            // Loading overlay functions
            function showLoading() {
                const overlay = document.getElementById('loadingOverlay');
                overlay.classList.add('active');
            }
            
            function hideLoading() {
                const overlay = document.getElementById('loadingOverlay');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>