<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white shadow-lg">
            <div class="p-4 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">STUDENT DASHBOARD</h1>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('student.enroll') }}" 
                   class="block px-6 py-3 {{ request()->routeIs('student.enroll') ? 'bg-indigo-700' : 'text-indigo-200 hover:bg-indigo-700' }} transition duration-200">
                    <i class="fas fa-book mr-3"></i> Course Enrollment
                </a>
                
                @if(auth()->user()->enrolledCourse)
                <a href="{{ route('student.units.index') }}" 
                   class="block px-6 py-3 {{ request()->routeIs('student.units') ? 'bg-indigo-700' : 'text-indigo-200 hover:bg-indigo-700' }} transition duration-200">
                    <i class="fas fa-tasks mr-3"></i> Unit Registration
                </a>
                @endif
                
                <a href="{{ route('student.grades.index') }}" class="block px-6 py-3 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
                    <i class="fas fa-chart-bar mr-3"></i> View Results
                </a>
                <a href="#" class="block px-6 py-3 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
                    <i class="fas fa-credit-card mr-3"></i> Pay Fee
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    
                    <!-- User Avatar with Dropdown -->
<div class="flex items-center space-x-4">
    <div class="relative" x-data="{ open: false }">
        <!-- Button with Avatar and SVG Dropdown Toggle -->
        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-xl">
                {{ Str::limit(auth()->user()->name) }}
            </div>
            <!-- Dropdown Arrow -->
            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" @click.outside="open = false" x-transition
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Logout</a>
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}</h3>
                        
                                 @if(auth()->user()->enrolledCourse)
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-blue-800">Currently Enrolled In:</h4>
                                <p class="text-lg mt-1">{{ auth()->user()->enrolledCourse->course->title }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                {{ auth()->user()->enrollment?->unitRegistrations?->count() ?? 0 }} units registered
                                </p>

                                
                                <div class="mt-4 space-x-3">
                                    <a href="{{ route('student.units.index') }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                                        Manage Units
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                <h4 class="font-medium text-yellow-800">No Active Enrollment</h4>
                                <p class="mt-1">You need to enroll in a course to register for units.</p>
                                
                                <div class="mt-3">
                                    <a href="{{ route('student.enroll') }}" 
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                                        Enroll in Course
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                                    <i class="fas fa-book fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Enrolled Course</p>
                                    <p class="text-xl font-semibold text-gray-900">
                                        {{ auth()->user()->enrolledCourse ? auth()->user()->enrolledCourse->course->title : 'None' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                    <i class="fas fa-tasks fa-lg"></i>
                                </div>
                                <div>
    <p class="text-sm font-medium text-gray-500">Registered Units</p>
    <p class="text-xl font-semibold text-gray-900">
        {{ auth()->user()->enrollment?->unitRegistrations?->count() ?? 0 }}
    </p>
</div>

                            </div>
                        </div>
                        
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <i class="fas fa-check-circle fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Completed Units</p>
                                    <p class="text-xl font-semibold text-gray-900">
                                    {{ collect(auth()->user()->unitRegistrations)->where('status', 'completed')->count() }}

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            @if(auth()->user()->enrolledCourse)
                                @forelse(auth()->user()->unitRegistrations()->latest()->take(3)->get() as $registration)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            Registered for {{ $registration->unit->title }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $registration->unit->course->title }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $registration->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                @empty
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            No recent unit registrations
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Register for units in your enrolled course
                                        </p>
                                    </div>
                                </div>
                                @endforelse
                            @else
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">
                                        No course enrollment
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Enroll in a course to view your activity
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Simple JavaScript for dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profileButton = document.querySelector('.relative button');
            const dropdownMenu = document.getElementById('profileDropdown');
            
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.relative')) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>