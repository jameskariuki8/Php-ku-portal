<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white shadow-lg">
            <div class="p-4 border-b border-indigo-700">
                <h1 class="text-2xl font-bold">STUDENT DASHBOARD</h1>
            </div>
            
            <nav class="mt-6">
            <a href="{{ route('student.dashboard') }}" 
                   class="block px-6 py-3 {{ request()->routeIs('student.dashboard') ? 'bg-indigo-700' : 'text-indigo-200 hover:bg-indigo-700' }} transition duration-200">
                    <i class="fas fa-book mr-3"></i> Dashboard
                </a>
                <a href="{{ route('student.enroll') }}" 
                   class="block px-6 py-3 {{ request()->routeIs('student.enroll') ? 'bg-indigo-700' : 'text-indigo-200 hover:bg-indigo-700' }} transition duration-200">
                    <i class="fas fa-book mr-3"></i> Course Enrollment
                </a>
                
                @if(auth()->user()->enrolledCourse)
                <a href="{{ route('student.units.index') }}" 
                   class="block px-6 py-3 {{ request()->routeIs('student.units.*') ? 'bg-indigo-700' : 'text-indigo-200 hover:bg-indigo-700' }} transition duration-200">
                    <i class="fas fa-tasks mr-3"></i> Unit Registration
                </a>
                @endif
                
                <a href="#" class="block px-6 py-3 text-indigo-200 hover:bg-indigo-700 hover:text-white transition duration-200">
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
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    
                    <!-- User Avatar with Dropdown -->
                    <div class="flex items-center space-x-4" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                {{ Str::limit(auth()->user()->name, 1, '') }}
                            </div>
                            <svg class="h-5 w-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-6 mt-12 w-48 bg-white rounded-md shadow-lg z-50 py-1">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-100">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>