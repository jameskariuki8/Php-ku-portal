<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .sidebar-item.active {
            background-color: #4f46e5;
            color: white;
        }
        .sidebar-item:hover:not(.active) {
            background-color: #e0e7ff;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <div class="p-5 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-indigo-700">Admin Dashboard</h1>
            </div>
            
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-5 mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">New Bar</h3>
                </div>
                
                <div class="space-y-1 px-3">
                    <a href="{{ route('admin.teacher.add') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-plus-circle mr-3 text-indigo-500"></i> Add Teacher
                    </a>
                    <a href="{{ route('admin.teacher.view') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-eye mr-3 text-indigo-500"></i> View Teachers
                    </a>
                    <a href="{{ route('admin.courses.view') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-list-alt mr-3 text-indigo-500"></i> View Course
                    </a>
                    <a href="#" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-users mr-3 text-indigo-500"></i> View Students
                    </a>
                </div>
                
                <div class="px-5 mt-8 mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Courses</h3>
                </div>
                
                <div class="space-y-1 px-3">
                    <a href="{{ route('admin.courses.add') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-plus-circle mr-3 text-indigo-500"></i> Add Courses
                    </a>
                    <a href="#" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200">
                        <i class="fas fa-cubes mr-3 text-indigo-500"></i> View Units
                    </a>
                </div>
            </nav>
            
            <!-- Sidebar footer -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                        A
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Admin User</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex justify-between items-center px-6 py-4">
                    <div class="flex items-center">
                        <button class="mr-4 text-gray-500 focus:outline-none lg:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-semibold text-gray-800">Dashboard Overview</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                         <button class="flex items-center space-x-2 focus:outline-none">
                          <div class="min-w-max px-3 py-1 rounded-full bg-indigo-100 text-indigo-600 font-semibold">
                                @auth
                                   {{ Auth::user()->name }}
                                @endauth
                         </div>
                      </button>
                   </div>

                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <div class="max-w-7xl mx-auto">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                    <i class="fas fa-users fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total Students</p>
                                    <p class="text-2xl font-semibold text-gray-900">1,248</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-book fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Active Courses</p>
                                    <p class="text-2xl font-semibold text-gray-900">24</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="fas fa-cubes fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Course Units</p>
                                    <p class="text-2xl font-semibold text-gray-900">156</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                                    <i class="fas fa-chart-line fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">New Registrations</p>
                                    <p class="text-2xl font-semibold text-gray-900">48</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity and Quick Actions -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Recent Activity -->
                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">5 new students registered</p>
                                        <p class="text-sm text-gray-500">New students joined the platform</p>
                                        <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">New course added</p>
                                        <p class="text-sm text-gray-500">"Advanced Mathematics" was added</p>
                                        <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas fa-cube"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">3 new units published</p>
                                        <p class="text-sm text-gray-500">New learning materials available</p>
                                        <p class="text-xs text-gray-400 mt-1">2 days ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="#" class="block px-4 py-3 bg-indigo-50 text-indigo-700 rounded-lg font-medium hover:bg-indigo-100 transition duration-200">
                                    <i class="fas fa-plus-circle mr-2"></i> Add New Student
                                </a>
                                <a href="#" class="block px-4 py-3 bg-green-50 text-green-700 rounded-lg font-medium hover:bg-green-100 transition duration-200">
                                    <i class="fas fa-book mr-2"></i> Create New Course
                                </a>
                                <a href="#" class="block px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition duration-200">
                                    <i class="fas fa-cube mr-2"></i> Add Course Unit
                                </a>
                                <a href="#" class="block px-4 py-3 bg-purple-50 text-purple-700 rounded-lg font-medium hover:bg-purple-100 transition duration-200">
                                    <i class="fas fa-file-export mr-2"></i> Generate Reports
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Simple JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Make sidebar items interactive
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Mobile sidebar toggle (would need proper implementation)
            const mobileMenuButton = document.querySelector('header button.lg\\:hidden');
            const sidebar = document.querySelector('div.w-64');
            
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>