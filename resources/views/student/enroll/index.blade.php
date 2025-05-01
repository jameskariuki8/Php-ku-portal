@extends('layouts.student')

@section('title', 'Unit Registration')
@section('header', 'Unit Registation')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .course-card {
            transition: all 0.2s ease;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>


        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Page Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">Course Enrollment</h2>
                    <p class="text-blue-100 mt-1">Manage your academic courses</p>
                </div>
                
                <!-- Flash Messages -->
                <div class="px-6 pt-4">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Area -->
                <div class="p-6">
                    @if($enrollment)
                        <!-- Current Enrollment Card -->
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-5 mb-8">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-blue-800">Current Enrollment</h3>
                                    <div class="mt-3">
                                        <p class="text-xl font-medium text-gray-900">{{ $enrollment->course->title }}</p>
                                        <p class="text-blue-600">{{ $enrollment->course->course_code }} • {{ $enrollment->course->credit_hours }} credits</p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            <span class="font-medium">Enrollment Date:</span> 
                                            {{ $enrollment->enrollment_date->format('F j, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <form action="{{ route('student.enroll', $enrollment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-white text-red-600 border border-red-200 rounded-md hover:bg-red-50 transition-colors"
                                            onclick="return confirm('Are you sure you want to withdraw from this course?')">
                                        Withdraw
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex justify-end">
                            <a href="{{ route('student.units.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                Proceed to Unit Registration
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    @else
                        <!-- Enrollment Form -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Available Courses</h3>
                                <p class="mt-1 text-sm text-gray-500">Select a course to enroll in for the current semester.</p>
                            </div>
                            
                            <form action="{{ route('student.enroll') }}" method="POST" class="space-y-6">
                                @csrf
                                
                                <div class="space-y-2">
                                    <label for="course_id" class="block text-sm font-medium text-gray-700">
                                        Select Course
                                    </label>
                                    <select id="course_id" name="course_id" required
                                        class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                                        <option value="">-- Select a Course --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">
                                                {{ $course->course_code }} - {{ $course->title }} ({{ $course->credit_hours }} credits)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="pt-2">
                                    <button type="submit" 
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                        Enroll in Selected Course
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    @endsection
