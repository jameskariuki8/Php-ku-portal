<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white shadow-lg">
            <div class="p-4 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">STUDENT DASHBOARD</h1>
            </div>
            
            <nav class="mt-6">
                <div class="px-6 py-3 bg-indigo-900 font-medium">
                    <span class="flex items-center">
                        <i class="fas fa-bars mr-3"></i>
                        Enroll Course
                    </span>
                </div>
                
                <a href="#" class="block px-6 py-3 mt-2 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
                    <i class="fas fa-envelope mr-3"></i> Register Units
                </a>
                <a href="#" class="block px-6 py-3 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
                    <i class="fas fa-book mr-3"></i> View Results
                </a>
                <a href="#" class="block px-6 py-3 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
                    <i class="fas fa-chart-bar mr-3"></i> Pay Fee
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                    FP
                                </div>
                                <span class="text-gray-700">First Name</span>
                                <i class="fas fa-chevron-down text-gray-500"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">View Profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <!-- Welcome Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome back, First Name!</h3>
                        <p class="text-gray-600">Here's what's happening with your courses today.</p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email Course</p>
                                    <p class="text-xl font-semibold text-gray-900">3 New</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-book fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Master Units</p>
                                    <p class="text-xl font-semibold text-gray-900">5 Active</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="fas fa-chart-bar fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">View Results</p>
                                    <p class="text-xl font-semibold text-gray-900">2 Updated</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">New unit available</p>
                                    <p class="text-sm text-gray-500">Mathematics Unit 4 is now available</p>
                                    <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Assignment submitted</p>
                                    <p class="text-sm text-gray-500">Your Science assignment was submitted</p>
                                    <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Simple JavaScript for dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profileButton = document.querySelector('.relative button');
            const dropdownMenu = document.querySelector('.relative .hidden');
            
            profileButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileButton.contains(event.target) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>