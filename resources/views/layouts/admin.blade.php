<!-- resources/views/layouts/admin.blade.php -->
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
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Management</h3>
                </div>
                
                <div class="space-y-1 px-3">
                    <a href="{{ route('admin.teacher.add') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200 {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle mr-3 text-indigo-500"></i> Add Teacher
                    </a>
                    <a href="{{ route('admin.teacher.view') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200 {{ request()->routeIs('admin.teachers.view') ? 'active' : '' }}">
                        <i class="fas fa-eye mr-3 text-indigo-500"></i> View Teachers
                    </a>
                    <a href="{{ route('admin.courses.view') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200 {{ request()->routeIs('admin.courses.view') ? 'active' : '' }}">
                        <i class="fas fa-list-alt mr-3 text-indigo-500"></i> View Courses
                    </a>
                    <a href="{{ route('admin.courses.add') }}" class="sidebar-item block px-4 py-3 rounded-lg text-gray-700 font-medium transition duration-200 {{ request()->routeIs('admin.courses.add') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle mr-3 text-indigo-500"></i> Add Course
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
                        <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard Overview')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                       
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
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Simple JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
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