<?php
include "../../auth/auth_admin.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management System</title>
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
        .sidebar-gradient {
            background: linear-gradient(180deg, #20B2AA 0%, #87CEEB 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(32, 178, 170, 0.15);
        }
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .nav-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-right: 4px solid white;
        }
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
        .status-present { background: #10B981; }
        .status-absent { background: #EF4444; }
        .status-late { background: #F59E0B; }
        .digital-clock {
            font-family: 'Courier New', monospace;
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Mobile Menu Button -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-bluegreen text-white p-2 rounded-lg shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="mobile-menu lg:transform-none fixed left-0 top-0 h-full w-64 sidebar-gradient text-white z-40 shadow-2xl">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-bluegreen" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold">AttendanceHub</h1>
                    <p class="text-sm opacity-80">Management System</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="privatenexus" class="nav-item active flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('dashboard')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('checkin'); return false;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                    </svg>
                    <span>Check In/Out</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('attendance');  return false;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    <span>Attendance Records</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('employees');  return false;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7c0-2.21-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4 4-1.79 4-4zm-4 6c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>Employees</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('reports');  return false;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Reports</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('settings');  return false;">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                    </svg>
                    <span>Settings</span>
                </a>
                                <a href="logout" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('settings')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                    </svg>
                    <span>logout</span>
                </a>
            </nav>
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6">
            <div class="flex items-center space-x-3 p-3 bg-white bg-opacity-10 rounded-lg">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <span class="text-bluegreen font-bold">HR</span>
                </div>
                <div>
                    <p class="font-semibold">HR Manager</p>
                    <p class="text-sm opacity-80">Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="lg:ml-0 ml-12">
                    <h2 id="pageTitle" class="text-2xl font-bold text-gray-800">Attendance Dashboard</h2>
                    <p class="text-gray-600">Today is <span id="currentDate"></span></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <div id="currentTime" class="digital-clock text-bluegreen"></div>
                        <p class="text-sm text-gray-500">Current Time</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-4 lg:p-6">
            <!-- Dashboard Section -->
            <div id="dashboardSection">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Employees</p>
                                <p class="text-3xl font-bold text-bluegreen">156</p>
                                <p class="text-green-500 text-sm">Active workforce</p>
                            </div>
                            <div class="w-12 h-12 bg-skyblue bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-skyblue" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7c0-2.21-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4 4-1.79 4-4zm-4 6c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Present Today</p>
                                <p class="text-3xl font-bold text-green-600">142</p>
                                <p class="text-green-500 text-sm">91% attendance rate</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Absent Today</p>
                                <p class="text-3xl font-bold text-red-600">8</p>
                                <p class="text-red-500 text-sm">5% absent rate</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 7 9.5l3.5 3.5L7 16.5 8.5 18l3.5-3.5L15.5 18 17 16.5 13.5 13 17 9.5 15.5 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Late Arrivals</p>
                                <p class="text-3xl font-bold text-yellow-600">6</p>
                                <p class="text-yellow-500 text-sm">4% late rate</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity and Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Check-ins</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">JS</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">John Smith checked in</p>
                                    <p class="text-xs text-gray-500">09:15 AM - On time</p>
                                </div>
                                <div class="w-3 h-3 bg-green-500 rounded-full pulse-dot"></div>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-skyblue rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">MJ</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Mary Johnson checked in</p>
                                    <p class="text-xs text-gray-500">09:30 AM - Late</p>
                                </div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full pulse-dot"></div>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-bluegreen rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">RB</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Robert Brown checked out</p>
                                    <p class="text-xs text-gray-500">06:00 PM - Full day</p>
                                </div>
                                <div class="w-3 h-3 bg-blue-500 rounded-full pulse-dot"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <button onclick="showSection('checkin')" class="p-4 bg-skyblue bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all duration-300 text-center">
                                <svg class="w-8 h-8 text-skyblue mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Check In/Out</p>
                            </button>
                            <button onclick="showSection('employees')" class="p-4 bg-bluegreen bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all duration-300 text-center">
                                <svg class="w-8 h-8 text-bluegreen mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Add Employee</p>
                            </button>
                            <button onclick="showSection('reports')" class="p-4 bg-green-100 hover:bg-green-200 rounded-lg transition-all duration-300 text-center">
                                <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700">View Reports</p>
                            </button>
                            <button onclick="showSection('attendance')" class="p-4 bg-purple-100 hover:bg-purple-200 rounded-lg transition-all duration-300 text-center">
                                <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Attendance Log</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Check In/Out Section -->
            <div id="checkinSection" class="hidden">
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="mb-8">
                            <div id="clockDisplay" class="digital-clock text-bluegreen mb-4"></div>
                            <p class="text-gray-600">Current Time</p>
                        </div>

                        <div class="mb-8">
                            <input type="text" id="employeeId" placeholder="Enter Employee ID" class="w-full p-4 border-2 border-gray-300 rounded-lg text-center text-lg focus:border-bluegreen focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <button onclick="checkIn()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                                </svg>
                                Check In
                            </button>
                            <button onclick="checkOut()" class="bg-red-500 hover:bg-red-600 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                <svg class="w-6 h-6 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 6L12 10.5 8.5 8 7 9.5l3.5 3.5L7 16.5 8.5 18l3.5-3.5L15.5 18 17 16.5 13.5 13 17 9.5 15.5 8z"/>
                                </svg>
                                Check Out
                            </button>
                        </div>

                        <div id="checkInMessage" class="hidden p-4 rounded-lg mb-4"></div>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Section -->
            <div id="attendanceSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Attendance Records</h3>
                        <div class="flex space-x-4">
                            <input type="date" id="dateFilter" class="border border-gray-300 rounded-lg px-3 py-2">
                            <button class="bg-bluegreen hover:bg-opacity-90 text-white px-4 py-2 rounded-lg">Filter</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Employee</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Date</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Check In</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Check Out</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Hours</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTableBody">
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">John Smith (EMP001)</td>
                                    <td class="py-3 px-4">2024-01-15</td>
                                    <td class="py-3 px-4">09:00 AM</td>
                                    <td class="py-3 px-4">06:00 PM</td>
                                    <td class="py-3 px-4">9h 0m</td>
                                    <td class="py-3 px-4"><span class="status-present text-white px-2 py-1 rounded-full text-xs">Present</span></td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Mary Johnson (EMP002)</td>
                                    <td class="py-3 px-4">2024-01-15</td>
                                    <td class="py-3 px-4">09:30 AM</td>
                                    <td class="py-3 px-4">05:30 PM</td>
                                    <td class="py-3 px-4">8h 0m</td>
                                    <td class="py-3 px-4"><span class="status-late text-white px-2 py-1 rounded-full text-xs">Late</span></td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Robert Brown (EMP003)</td>
                                    <td class="py-3 px-4">2024-01-15</td>
                                    <td class="py-3 px-4">-</td>
                                    <td class="py-3 px-4">-</td>
                                    <td class="py-3 px-4">0h 0m</td>
                                    <td class="py-3 px-4"><span class="status-absent text-white px-2 py-1 rounded-full text-xs">Absent</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Employees Section -->
            <div id="employeesSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Employee Management</h3>
                        <button class="bg-bluegreen hover:bg-opacity-90 text-white px-4 py-2 rounded-lg">Add New Employee</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">ID</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Department</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Position</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">EMP001</td>
                                    <td class="py-3 px-4">John Smith</td>
                                    <td class="py-3 px-4">IT</td>
                                    <td class="py-3 px-4">Developer</td>
                                    <td class="py-3 px-4"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button class="text-red-500 hover:text-red-700">Delete</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">EMP002</td>
                                    <td class="py-3 px-4">Mary Johnson</td>
                                    <td class="py-3 px-4">HR</td>
                                    <td class="py-3 px-4">Manager</td>
                                    <td class="py-3 px-4"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button class="text-red-500 hover:text-red-700">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div id="reportsSection" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Generate Reports</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option>Daily Attendance</option>
                                    <option>Weekly Summary</option>
                                    <option>Monthly Report</option>
                                    <option>Employee Timesheet</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                    <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                            </div>
                            <button class="w-full bg-bluegreen hover:bg-opacity-90 text-white py-3 rounded-lg">Generate Report</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700">Average Daily Attendance</span>
                                <span class="font-bold text-bluegreen">91.2%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700">Most Punctual Employee</span>
                                <span class="font-bold text-green-600">John Smith</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-700">Department with Best Attendance</span>
                                <span class="font-bold text-skyblue">IT Department</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div id="settingsSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">System Settings</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-700 mb-4">Working Hours</h4>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                                        <input type="time" value="09:00" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                                        <input type="time" value="18:00" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Late Threshold (minutes)</label>
                                    <input type="number" value="15" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-700 mb-4">Notifications</h4>
                            <div class="space-y-4">
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-3">
                                    <span class="text-gray-700">Email notifications for late arrivals</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-3">
                                    <span class="text-gray-700">Daily attendance summary</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="mr-3">
                                    <span class="text-gray-700">Weekly reports</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="bg-bluegreen hover:bg-opacity-90 text-white px-6 py-3 rounded-lg">Save Settings</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobileOverlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mobileOverlay.classList.toggle('hidden');
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            mobileOverlay.classList.add('hidden');
        });

        // Update time and date
        function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: false, 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const dateString = now.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
            
            const clockDisplay = document.getElementById('clockDisplay');
            if (clockDisplay) {
                clockDisplay.textContent = timeString;
            }
        }

        // Navigation functionality
        function showSection(sectionName) {
            const sections = ['dashboard', 'checkin', 'attendance', 'employees', 'reports', 'settings'];
            sections.forEach(section => {
                const element = document.getElementById(section + 'Section');
                if (element) {
                    element.classList.add('hidden');
                }
            });

            const selectedSection = document.getElementById(sectionName + 'Section');
            if (selectedSection) {
                selectedSection.classList.remove('hidden');
            }

            const titles = {
                dashboard: 'Attendance Dashboard',
                checkin: 'Check In/Out',
                attendance: 'Attendance Records',
                employees: 'Employee Management',
                reports: 'Reports & Analytics',
                settings: 'System Settings'
            };
            document.getElementById('pageTitle').textContent = titles[sectionName] || 'Dashboard';

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.nav-item').classList.add('active');

            sidebar.classList.remove('active');
            mobileOverlay.classList.add('hidden');
        }

        // Check in/out functionality
        function checkIn() {
            const employeeId = document.getElementById('employeeId').value;
            const messageDiv = document.getElementById('checkInMessage');
            
            if (!employeeId) {
                showMessage('Please enter Employee ID', 'error');
                return;
            }

            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit' 
            });

            showMessage(`✅ Check-in successful for ${employeeId} at ${timeString}`, 'success');
            document.getElementById('employeeId').value = '';
        }

        function checkOut() {
            const employeeId = document.getElementById('employeeId').value;
            
            if (!employeeId) {
                showMessage('Please enter Employee ID', 'error');
                return;
            }

            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit' 
            });

            showMessage(`✅ Check-out successful for ${employeeId} at ${timeString}`, 'success');
            document.getElementById('employeeId').value = '';
        }

        function showMessage(message, type) {
            const messageDiv = document.getElementById('checkInMessage');
            messageDiv.textContent = message;
            messageDiv.className = `p-4 rounded-lg mb-4 ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
            messageDiv.classList.remove('hidden');
            
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        // Initialize
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Set today's date in date filter
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const dateFilter = document.getElementById('dateFilter');
            if (dateFilter) {
                dateFilter.value = today;
            }
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'984b8b52f3eb8d03',t:'MTc1ODgxNDAzMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
