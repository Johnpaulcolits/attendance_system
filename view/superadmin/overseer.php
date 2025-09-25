
<?php

include "../../auth/auth_superadmin.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Student Attendance System</title>
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
        .status-active { background: #10B981; }
        .status-inactive { background: #EF4444; }
        .status-pending { background: #F59E0B; }
        .digital-clock {
            font-family: 'Courier New', monospace;
            font-size: 2rem;
            font-weight: bold;
        }
        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #20B2AA;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 8px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading .spinner {
            display: inline-block;
        }
        .loading:not(.spinner) .spinner {
            display: none;
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
    <div id="sidebar" class="mobile-menu lg:transform-none fixed left-0 top-0 h-full w-64 sidebar-gradient text-white z-40 shadow-2xl overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-bluegreen" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold">EduAttend</h1>
                    <p class="text-sm opacity-80">Super Admin</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="#" class="nav-item active flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('dashboard')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('schools')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                    </svg>
                    <span>Schools Management</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('teachers')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L12 2L3 7V9C3 10.1 3.9 11 5 11V17C5 18.1 5.9 19 7 19H9C10.1 19 11 18.1 11 17V11H13V17C13 18.1 13.9 19 15 19H17C18.1 19 19 18.1 19 17V11C20.1 11 21 10.1 21 9Z"/>
                    </svg>
                    <span>Teachers</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('students')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-6h3v-2c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v2h3v6H4zm16-10.5V9l-2.5-1.5L15 9V7.5l3.5-2L22 7.5z"/>
                    </svg>
                    <span>Students</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('analytics')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Analytics</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('reports')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    <span>System Reports</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('users')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7c0-2.21-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4 4-1.79 4-4zm-4 6c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>User Management</span>
                </a>
                <a href="#" class="nav-item flex items-center space-x-3 p-3 rounded-lg" onclick="showSection('settings')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                    </svg>
                    <span>System Settings</span>
                </a>
            </nav>
        </div>

        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-white border-opacity-20">
            <a href="logout" onclick="logout()" class="nav-item flex items-center space-x-3 p-3 rounded-lg bg-red-500 bg-opacity-20 hover:bg-opacity-30">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                <span>Logout</span>
            </a>
            <div class="flex items-center space-x-3 p-3 bg-white bg-opacity-10 rounded-lg mt-2">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <span class="text-bluegreen font-bold">SA</span>
                </div>
                <div>
                    <p class="font-semibold">Super Admin</p>
                    <p class="text-sm opacity-80">System Administrator</p>
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
                    <h2 id="pageTitle" class="text-2xl font-bold text-gray-800">Super Admin Dashboard</h2>
                    <p class="text-gray-600">System Overview - <span id="currentDate"></span></p>
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
                <!-- System Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Schools</p>
                                <p class="text-3xl font-bold text-bluegreen">24</p>
                                <p class="text-green-500 text-sm">+2 this month</p>
                            </div>
                            <div class="w-12 h-12 bg-skyblue bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-skyblue" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Students</p>
                                <p class="text-3xl font-bold text-green-600">15,847</p>
                                <p class="text-green-500 text-sm">Active learners</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zM4 18v-6h3v-2c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2v2h3v6H4zm16-10.5V9l-2.5-1.5L15 9V7.5l3.5-2L22 7.5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Teachers</p>
                                <p class="text-3xl font-bold text-purple-600">1,247</p>
                                <p class="text-purple-500 text-sm">Educators</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L12 2L3 7V9C3 10.1 3.9 11 5 11V17C5 18.1 5.9 19 7 19H9C10.1 19 11 18.1 11 17V11H13V17C13 18.1 13.9 19 15 19H17C18.1 19 19 18.1 19 17V11C20.1 11 21 10.1 21 9Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">System Uptime</p>
                                <p class="text-3xl font-bold text-blue-600">99.8%</p>
                                <p class="text-blue-500 text-sm">Last 30 days</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.5 17.5L4 13l1.41-1.41L10.5 16.8l8.09-8.09L20 10.22l-9.5 9.28z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Overview -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Attendance Overview</h3>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <p class="text-2xl font-bold text-green-600">14,523</p>
                                <p class="text-sm text-gray-600">Present Students</p>
                                <p class="text-xs text-green-500">91.6% attendance</p>
                            </div>
                            <div class="text-center p-4 bg-red-50 rounded-lg">
                                <p class="text-2xl font-bold text-red-600">1,324</p>
                                <p class="text-sm text-gray-600">Absent Students</p>
                                <p class="text-xs text-red-500">8.4% absence</p>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                <p class="text-2xl font-bold text-yellow-600">892</p>
                                <p class="text-sm text-gray-600">Late Arrivals</p>
                                <p class="text-xs text-yellow-500">5.6% late</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Overall Attendance Rate</span>
                                <span class="text-sm font-semibold text-green-600">91.6%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 91.6%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">System Alerts</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Low attendance at Lincoln High</p>
                                    <p class="text-xs text-gray-500">Below 85% threshold</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">New school registration</p>
                                    <p class="text-xs text-gray-500">Pending approval</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">System backup completed</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <button onclick="showSection('schools')" class="p-4 bg-skyblue bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all duration-300 text-center">
                            <svg class="w-8 h-8 text-skyblue mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Add School</p>
                        </button>
                        <button onclick="showSection('users')" class="p-4 bg-bluegreen bg-opacity-10 hover:bg-opacity-20 rounded-lg transition-all duration-300 text-center">
                            <svg class="w-8 h-8 text-bluegreen mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V8c0-.55-.45-1-1-1s-1 .45-1 1v2H2c-.55 0-1 .45-1 1s.45 1 1 1h2v2c0 .55.45 1 1 1s1-.45 1-1v-2h2c.55 0 1-.45 1-1s-.45-1-1-1H6z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Manage Users</p>
                        </button>
                        <button onclick="showSection('reports')" class="p-4 bg-green-100 hover:bg-green-200 rounded-lg transition-all duration-300 text-center">
                            <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Generate Reports</p>
                        </button>
                        <button onclick="showSection('settings')" class="p-4 bg-purple-100 hover:bg-purple-200 rounded-lg transition-all duration-300 text-center">
                            <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">System Settings</p>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Schools Management Section -->
            <div id="schoolsSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Schools Management</h3>
                        <div class="flex space-x-4">
                            <button onclick="performAction(this, 'Adding new school...')" class="bg-bluegreen hover:bg-opacity-90 text-white px-4 py-2 rounded-lg">Add New School</button>
                            <button onclick="performAction(this, 'Exporting data...')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Export Data</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">School Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Location</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Students</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Teachers</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Lincoln High School</td>
                                    <td class="py-3 px-4">New York, NY</td>
                                    <td class="py-3 px-4">1,247</td>
                                    <td class="py-3 px-4">89</td>
                                    <td class="py-3 px-4"><span class="status-active text-white px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Updating school...')" class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button onclick="performAction(this, 'Viewing details...')" class="text-green-500 hover:text-green-700 mr-2">View</button>
                                        <button onclick="performAction(this, 'Suspending school...')" class="text-red-500 hover:text-red-700">Suspend</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Washington Elementary</td>
                                    <td class="py-3 px-4">Los Angeles, CA</td>
                                    <td class="py-3 px-4">892</td>
                                    <td class="py-3 px-4">67</td>
                                    <td class="py-3 px-4"><span class="status-active text-white px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Updating school...')" class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button onclick="performAction(this, 'Viewing details...')" class="text-green-500 hover:text-green-700 mr-2">View</button>
                                        <button onclick="performAction(this, 'Suspending school...')" class="text-red-500 hover:text-red-700">Suspend</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Roosevelt Middle School</td>
                                    <td class="py-3 px-4">Chicago, IL</td>
                                    <td class="py-3 px-4">654</td>
                                    <td class="py-3 px-4">45</td>
                                    <td class="py-3 px-4"><span class="status-pending text-white px-2 py-1 rounded-full text-xs">Pending</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Approving school...')" class="text-green-500 hover:text-green-700 mr-2">Approve</button>
                                        <button onclick="performAction(this, 'Rejecting application...')" class="text-red-500 hover:text-red-700">Reject</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Teachers Section -->
            <div id="teachersSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Teachers Overview</h3>
                        <div class="flex space-x-4">
                            <select class="border border-gray-300 rounded-lg px-3 py-2">
                                <option>All Schools</option>
                                <option>Lincoln High School</option>
                                <option>Washington Elementary</option>
                            </select>
                            <button onclick="performAction(this, 'Exporting teacher data...')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Export</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">1,247</p>
                            <p class="text-sm text-gray-600">Total Teachers</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">1,198</p>
                            <p class="text-sm text-gray-600">Active Teachers</p>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">49</p>
                            <p class="text-sm text-gray-600">On Leave</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Teacher Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">School</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Subject</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Classes</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Performance</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Sarah Johnson</td>
                                    <td class="py-3 px-4">Lincoln High School</td>
                                    <td class="py-3 px-4">Mathematics</td>
                                    <td class="py-3 px-4">5</td>
                                    <td class="py-3 px-4"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Excellent</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Viewing teacher profile...')" class="text-skyblue hover:text-bluegreen mr-2">View</button>
                                        <button onclick="performAction(this, 'Sending message...')" class="text-green-500 hover:text-green-700">Message</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Michael Brown</td>
                                    <td class="py-3 px-4">Washington Elementary</td>
                                    <td class="py-3 px-4">Science</td>
                                    <td class="py-3 px-4">4</td>
                                    <td class="py-3 px-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Good</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Viewing teacher profile...')" class="text-skyblue hover:text-bluegreen mr-2">View</button>
                                        <button onclick="performAction(this, 'Sending message...')" class="text-green-500 hover:text-green-700">Message</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Students Section -->
            <div id="studentsSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Students Overview</h3>
                        <div class="flex space-x-4">
                            <input type="text" placeholder="Search students..." class="border border-gray-300 rounded-lg px-3 py-2">
                            <button onclick="performAction(this, 'Searching students...')" class="bg-bluegreen hover:bg-opacity-90 text-white px-4 py-2 rounded-lg">Search</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">15,847</p>
                            <p class="text-sm text-gray-600">Total Students</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">14,523</p>
                            <p class="text-sm text-gray-600">Present Today</p>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <p class="text-2xl font-bold text-red-600">1,324</p>
                            <p class="text-sm text-gray-600">Absent Today</p>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">892</p>
                            <p class="text-sm text-gray-600">Late Today</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Student Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">School</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Grade</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Attendance Rate</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Emma Wilson</td>
                                    <td class="py-3 px-4">Lincoln High School</td>
                                    <td class="py-3 px-4">Grade 10</td>
                                    <td class="py-3 px-4">96.5%</td>
                                    <td class="py-3 px-4"><span class="status-active text-white px-2 py-1 rounded-full text-xs">Present</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Viewing student profile...')" class="text-skyblue hover:text-bluegreen mr-2">View</button>
                                        <button onclick="performAction(this, 'Viewing attendance...')" class="text-green-500 hover:text-green-700">Attendance</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">James Davis</td>
                                    <td class="py-3 px-4">Washington Elementary</td>
                                    <td class="py-3 px-4">Grade 5</td>
                                    <td class="py-3 px-4">89.2%</td>
                                    <td class="py-3 px-4"><span class="status-inactive text-white px-2 py-1 rounded-full text-xs">Absent</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Viewing student profile...')" class="text-skyblue hover:text-bluegreen mr-2">View</button>
                                        <button onclick="performAction(this, 'Viewing attendance...')" class="text-green-500 hover:text-green-700">Attendance</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Analytics Section -->
            <div id="analyticsSection" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Attendance Trends</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">This Week</span>
                                <span class="text-sm font-semibold text-green-600">92.3%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 92.3%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Last Week</span>
                                <span class="text-sm font-semibold text-blue-600">89.7%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 89.7%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">This Month</span>
                                <span class="text-sm font-semibold text-purple-600">91.1%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 91.1%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Performing Schools</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="text-gray-700">Lincoln High School</span>
                                <span class="font-bold text-green-600">97.2%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-gray-700">Washington Elementary</span>
                                <span class="font-bold text-blue-600">95.8%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                                <span class="text-gray-700">Roosevelt Middle School</span>
                                <span class="font-bold text-purple-600">94.3%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Section -->
            <div id="reportsSection" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Generate System Reports</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option>System-wide Attendance</option>
                                    <option>School Performance</option>
                                    <option>Teacher Analytics</option>
                                    <option>Student Trends</option>
                                    <option>Usage Statistics</option>
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
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Schools (Optional)</label>
                                <select multiple class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option>All Schools</option>
                                    <option>Lincoln High School</option>
                                    <option>Washington Elementary</option>
                                    <option>Roosevelt Middle School</option>
                                </select>
                            </div>
                            <button onclick="performAction(this, 'Generating system report...')" class="w-full bg-bluegreen hover:bg-opacity-90 text-white py-3 rounded-lg">Generate Report</button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Reports</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium">Monthly Attendance Report</p>
                                    <p class="text-xs text-gray-500">Generated 2 hours ago</p>
                                </div>
                                <button onclick="performAction(this, 'Downloading report...')" class="text-bluegreen hover:text-blue-700">Download</button>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium">School Performance Analysis</p>
                                    <p class="text-xs text-gray-500">Generated yesterday</p>
                                </div>
                                <button onclick="performAction(this, 'Downloading report...')" class="text-bluegreen hover:text-blue-700">Download</button>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium">System Usage Statistics</p>
                                    <p class="text-xs text-gray-500">Generated 3 days ago</p>
                                </div>
                                <button onclick="performAction(this, 'Downloading report...')" class="text-bluegreen hover:text-blue-700">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management Section -->
            <div id="usersSection" class="hidden">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">User Management</h3>
                        <div class="flex space-x-4">
                            <button onclick="performAction(this, 'Adding new user...')" class="bg-bluegreen hover:bg-opacity-90 text-white px-4 py-2 rounded-lg">Add User</button>
                            <button onclick="performAction(this, 'Bulk operations...')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Bulk Actions</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">1,271</p>
                            <p class="text-sm text-gray-600">Total Users</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">24</p>
                            <p class="text-sm text-gray-600">School Admins</p>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <p class="text-2xl font-bold text-purple-600">1,247</p>
                            <p class="text-sm text-gray-600">Teachers</p>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600">1,198</p>
                            <p class="text-sm text-gray-600">Active Users</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Name</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Role</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">School</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">John Smith</td>
                                    <td class="py-3 px-4">john.smith@lincoln.edu</td>
                                    <td class="py-3 px-4">School Admin</td>
                                    <td class="py-3 px-4">Lincoln High School</td>
                                    <td class="py-3 px-4"><span class="status-active text-white px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Editing user...')" class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button onclick="performAction(this, 'Suspending user...')" class="text-red-500 hover:text-red-700">Suspend</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="py-3 px-4">Sarah Johnson</td>
                                    <td class="py-3 px-4">sarah.j@lincoln.edu</td>
                                    <td class="py-3 px-4">Teacher</td>
                                    <td class="py-3 px-4">Lincoln High School</td>
                                    <td class="py-3 px-4"><span class="status-active text-white px-2 py-1 rounded-full text-xs">Active</span></td>
                                    <td class="py-3 px-4">
                                        <button onclick="performAction(this, 'Editing user...')" class="text-skyblue hover:text-bluegreen mr-2">Edit</button>
                                        <button onclick="performAction(this, 'Suspending user...')" class="text-red-500 hover:text-red-700">Suspend</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Settings Section -->
            <div id="settingsSection" class="hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">System Configuration</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option>2023-2024</option>
                                    <option>2024-2025</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Attendance Threshold</label>
                                <input type="number" value="85" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                <p class="text-xs text-gray-500 mt-1">Minimum attendance percentage for alerts</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Late Arrival Grace Period (minutes)</label>
                                <input type="number" value="15" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">System Timezone</label>
                                <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option>Eastern Time (ET)</option>
                                    <option>Central Time (CT)</option>
                                    <option>Mountain Time (MT)</option>
                                    <option>Pacific Time (PT)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Notification Settings</h3>
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" checked class="mr-3">
                                <span class="text-gray-700">Email alerts for low attendance</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked class="mr-3">
                                <span class="text-gray-700">Daily system reports</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-3">
                                <span class="text-gray-700">Weekly performance summaries</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked class="mr-3">
                                <span class="text-gray-700">System maintenance notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-3">
                                <span class="text-gray-700">New school registration alerts</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">System Maintenance</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button onclick="performAction(this, 'Creating backup...')" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg">Backup System</button>
                        <button onclick="performAction(this, 'Clearing cache...')" class="bg-yellow-500 hover:bg-yellow-600 text-white py-3 px-4 rounded-lg">Clear Cache</button>
                        <button onclick="performAction(this, 'Updating system...')" class="bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg">System Update</button>
                    </div>
                    <div class="mt-6">
                        <button onclick="performAction(this, 'Saving all settings...')" class="bg-bluegreen hover:bg-opacity-90 text-white px-6 py-3 rounded-lg">Save All Settings</button>
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
        }

        // Navigation functionality
        function showSection(sectionName) {
            const sections = ['dashboard', 'schools', 'teachers', 'students', 'analytics', 'reports', 'users', 'settings'];
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
                dashboard: 'Super Admin Dashboard',
                schools: 'Schools Management',
                teachers: 'Teachers Overview',
                students: 'Students Management',
                analytics: 'System Analytics',
                reports: 'System Reports',
                users: 'User Management',
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

        // Loading functionality with spinner
        function performAction(button, message) {
            const originalText = button.innerHTML;
            button.classList.add('loading');
            button.innerHTML = `<span class="spinner"></span>${message}`;
            button.disabled = true;
            
            setTimeout(() => {
                button.classList.remove('loading');
                button.innerHTML = originalText;
                button.disabled = false;
                
                // Show success message for different actions
                if (message.includes('Deleting') || message.includes('Suspending')) {
                    alert('✅ Action completed successfully!');
                } else if (message.includes('Adding') || message.includes('Creating')) {
                    alert('✅ Item created successfully!');
                } else if (message.includes('Updating') || message.includes('Editing') || message.includes('Saving')) {
                    alert('✅ Changes saved successfully!');
                } else if (message.includes('Generating') || message.includes('Exporting')) {
                    alert('✅ Report generated successfully!');
                } else if (message.includes('Downloading')) {
                    alert('✅ Download started!');
                } else if (message.includes('Searching') || message.includes('Filtering')) {
                    alert('✅ Search completed!');
                } else if (message.includes('Approving')) {
                    alert('✅ School approved successfully!');
                } else if (message.includes('Rejecting')) {
                    alert('✅ Application rejected!');
                } else if (message.includes('backup') || message.includes('cache') || message.includes('update')) {
                    alert('✅ System maintenance completed!');
                } else {
                    alert('✅ Action completed successfully!');
                }
            }, 500);
        }

        // Logout functionality
        function logout() {
            if (confirm('Are you sure you want to logout from Super Admin panel?')) {
                const button = event.target.closest('a');
                button.classList.add('loading');
                button.innerHTML = '<span class="spinner"></span><span>Logging out...</span>';
                
                setTimeout(() => {
                    alert('✅ Logged out successfully!');
                    // In a real app, this would redirect to login page
                    window.location.reload();
                }, 500);
            }
        }

        // Initialize
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Set today's date in date filters
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                if (!input.value) {
                    input.value = today;
                }
            });
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'984ba23045a78d0b',t:'MTc1ODgxNDk2OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
