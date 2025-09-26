<?php
include "../../auth/auth_student.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
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
                        <p class="text-white/80 text-sm"><?php echo $idnumber?></p>
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
                                    <p class="text-sm font-medium text-gray-900"><?php echo $fname ." ".$lname?></p>
                                    <p class="text-xs text-gray-500"><?php echo $role ?></p>
                                </div>
                                <button id="profileButtons" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
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

   <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Student Profile</h2>
        
    </div>

    <!-- Profile Content -->
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Profile Image -->
            <div class="flex-shrink-0 relative">
    <img id="profilePic" src="https://via.placeholder.com/150" 
         alt="Profile" 
         class="w-32 h-32 rounded-full object-cover shadow-lg border">

    <!-- Camera Icon Overlay -->
    <button onclick="openPicModal()" 
            class="absolute bottom-1 right-1 bg-blue-600 hover:bg-blue-700 p-2 rounded-full text-white shadow">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 01-2-2V9a2 2 0 012-2z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 13a3 3 0 100-6 3 3 0 000 6z"/>
        </svg>
    </button>
</div>

<!-- Modal -->
<div id="picModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <!-- Close Button -->
        <button onclick="closePicModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✕
        </button>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Profile Picture</h2>

        <!-- Upload Area -->
        <label for="profileUpload" 
               class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg h-40 cursor-pointer hover:border-blue-500 transition">
            <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0 0l-3-3m3 3l3-3M4 12a8 8 0 0116 0"/>
            </svg>
            <p class="text-gray-500">Click to upload</p>
            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 5MB</p>
        </label>
        <input type="file" id="profileUpload" accept="image/*" class="hidden" onchange="previewPic(event)">

        <!-- Preview -->
        <div class="mt-4 text-center hidden" id="previewContainer">
            <img id="previewImage" src="" class="mx-auto w-24 h-24 rounded-full object-cover border shadow">
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 mt-6">
            <button onclick="closePicModal()" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md">
                Cancel
            </button>
            <button onclick="savePic()" 
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md">
                Save Picture
            </button>
        </div>
    </div>
</div>


            <!-- Profile Information -->
            <div class="flex-1 text-center md:text-left w-full">
                <!-- Display Mode -->
                <div id="profileDisplay">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2" id="profileName"><?php echo $fname ." ". $lname?></h1>
                    <p class="text-lg text-gray-600 mb-6" id="profileDesc">
                        <?php
                        if($course === "BSIT"){
                            echo "Information Technology" ." ". "Student";
                        }
                        ?>
                    </p>
                    
                    <!-- Profile Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Student ID</label>
                            <p class="text-lg font-medium text-gray-800" id="profileID"><?php echo $idnumber?></p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Middle Name</label>
                            <p class="text-lg font-medium text-gray-800" id="profileEmail"><?php echo $mname ?></p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Year</label>
                            <p class="text-lg font-medium text-gray-800" id="profileYear"><?php echo $year?> Year</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Course</label>
                            <p class="text-lg font-medium text-gray-800" id="profileCourse">
                                <?php
                                 if($course === "BSIT"){
                            echo "BS Information Technology";
                        }
                                ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Edit Profile Button -->
                    <button onclick="editProfile()" 
                        class="bg-gradient-to-r from-bluegreen to-skyblue hover:from-skyblue hover:to-bluegreen text-white font-semibold py-3 px-8 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2 mx-auto md:mx-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </button>
                </div>

                <!-- Edit Mode -->
                <div id="profileEdit" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">First Name</label>
                            <input type="text" id="firstName" class="w-full border-gray-300 rounded-lg p-2" placeholder="<?php echo $fname ?>">
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Middle Name</label>
                            <input type="text" id="middleName" class="w-full border-gray-300 rounded-lg p-2" placeholder="<?php echo $mname ?>">
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Last Name</label>
                            <input type="text" id="lastName" class="w-full border-gray-300 rounded-lg p-2" placeholder="<?php echo $lname ?>">
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Year</label>
                            <select name="year_level" class="w-full border-gray-300 rounded-lg p-2">
                            <option value="<?php echo $year; ?>" selected><?php echo $year; ?></option>
    <?php
        $years = ["1st", "2nd", "3rd", "4th"];
        foreach ($years as $y) {
            if ($y != $year) {
                echo "<option value='$y'>$y</option>";
            }
        }
    ?>
                                    </select>

                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">Course</label>
                            <select name="course" class="w-full border-gray-300 rounded-lg p-2">
    <option value="<?php echo $course; ?>" selected><?php echo $course; ?></option>
    <?php
        $courses = [
            "BSIT",
            "BITM",
            "BSM",
            "BSCE"
        ];
        foreach ($courses as $c) {
            if ($c != $course) {
                echo "<option value='$c'>$c</option>";
            }
        }
    ?>
</select>

                        </div>
                    </div>

                    <!-- Save + Cancel Buttons -->
                    <div class="flex gap-4">
                        <button onclick="saveProfile()" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                            Save
                        </button>
                        <button onclick="cancelEdit()" 
                            class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
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
                        <span class="text-white font-bold text-3xl">AS</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Attendance System</h2>
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
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $fname ." ".$lname?></h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Year:</span> <?php echo strtoupper($year) ?> YEAR</p>
                        <p><span class="font-medium">Course:</span> <?php echo strtoupper($course) ?></p>
                    </div>
                </div>
                
                <!-- QR Code -->
                <div class="bg-white border-2 border-gray-200 rounded-xl p-4 mb-6">
                    <div class="w-48 h-48 mx-auto bg-white flex items-center justify-center">
                        <!-- QR Code SVG -->
                         <canvas id="qrcode"></canvas>
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

           // Pass PHP variables into JavaScript
    const data = {
      email:    "<?php echo $email; ?>",
      fname:    "<?php echo $fname; ?>",
      lname:    "<?php echo $lname; ?>",
      idnumber: "<?php echo $idnumber; ?>",
      year:     "<?php echo $year; ?>",
      course:   "<?php echo $course; ?>",
      role:     "<?php echo $role; ?>"
    };

    const jsonString = JSON.stringify(data);

    // Generate QR code
    QRCode.toCanvas(
      document.getElementById("qrcode"),
      jsonString,
      { errorCorrectionLevel: "L" },
      function (error) {
        if (error) console.error(error);
        console.log("QR Code generated!");
      }
    );  

        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Profile dropdown functionality
            const profileButton = document.getElementById('profileButton');
            const profileDropdown = document.getElementById('profileDropdown');
            const logoutButton = document.getElementById('logoutButton');
            const ViewButton = document.getElementById('profileButtons');
            
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


            ViewButton.addEventListener('click', function(){
                showLoading();

                setTimeout(()=>{
                    hideLoading();
                    window.location.href="profile";

                }, 1000)
            });
            
            // Add click handlers for Quick Action buttons with full page loading
//            const quickActionButtons = document.querySelectorAll('.grid button');

// quickActionButtons.forEach(button => {
//     button.addEventListener('click', function () {
//         const actionName = this.querySelector('.font-medium').innerText;
//         const path = this.dataset.path; // 👈 get path from button

//         showLoading();

//         setTimeout(() => {
//             hideLoading();
//             window.location.href = path; // 👈 redirect based on button
//         }, 1000);
//     });
// });

            
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
                    window.location.href="profile";
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


        function editProfile() {
    document.getElementById("profileDisplay").classList.add("hidden");
    document.getElementById("profileEdit").classList.remove("hidden");
}

function cancelEdit() {
    document.getElementById("profileEdit").classList.add("hidden");
    document.getElementById("profileDisplay").classList.remove("hidden");
}

function saveProfile() {
    // Get values
    let fname = document.getElementById("firstName").value;
    let mname = document.getElementById("middleName").value;
    let lname = document.getElementById("lastName").value;
    let year = document.getElementById("yearLevel").value;
    let course = document.getElementById("course").value;

    // Update display
    document.getElementById("profileName").innerText = fname + " " + lname;
    document.getElementById("profileDesc").innerText = course + " Student";
    document.getElementById("profileYear").innerText = year;
    document.getElementById("profileCourse").innerText = course;

    // Switch back
    cancelEdit();
}

function openPicModal() {
    document.getElementById("picModal").classList.remove("hidden");
}
function closePicModal() {
    document.getElementById("picModal").classList.add("hidden");
    document.getElementById("profileUpload").value = ""; // reset file input
}
function previewPic(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById("previewImage").src = e.target.result;
            document.getElementById("previewContainer").classList.remove("hidden");
        }
        reader.readAsDataURL(file);
    }
}
function savePic() {
    const preview = document.getElementById("previewImage").src;
    if (preview) {
        document.getElementById("profilePic").src = preview; // update profile picture
    }
    closePicModal();
}
    </script>
</body>
</html>