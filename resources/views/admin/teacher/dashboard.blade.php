@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Teacher Dashboard</h1>
        <div class="flex items-center space-x-4">
            <!-- Profile dropdown -->
            <div class="relative group">
                <div class="flex items-center space-x-2 cursor-pointer">
                    <!-- Oval/Circle wrapped username -->
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 transition">
                        {{ auth()->user()->name }}
                    </span>
                    <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
                <!-- Dropdown menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

  

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600">Here's an overview of your courses and students.</p>
        </div>

        <!-- Courses Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Add Units to Courses Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Add Units to Courses</h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>View enrolled students and fair courses</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Add Students Marks</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Send Marks to Students Via Emails</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Manage Courses
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.teacher.units') }}" class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition">
                        <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="text-sm font-medium text-indigo-700">Add Unit</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition">
                        <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium text-indigo-700">Students</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition">
                        <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium text-indigo-700">Grades</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg bg-indigo-50 hover:bg-indigo-100 transition">
                        <svg class="h-8 w-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium text-indigo-700">Messages</span>
                    </a>
                </div>
            </div>
        </div>

       
    </div>
</div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">&copy; {{ date('Y') }} School Management System. All rights reserved.</p>
        </div>
    </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@section('scripts')


@endsection