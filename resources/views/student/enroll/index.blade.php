@extends('layouts.student')

@section('title', 'Course Enrollment')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Course Enrollment</h2>
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($enrollment)
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <h3 class="font-medium text-blue-800">Currently Enrolled In:</h3>
                    <p class="text-lg mt-1">{{ $enrollment->course->title }} ({{ $enrollment->course->course_code }})</p>
                    <p class="text-sm text-gray-600 mt-1">Enrolled on: {{ $enrollment->enrollment_date->format('M d, Y') }}</p>
                    
                    <form action="{{ route('student.enroll', $enrollment->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200"
                                onclick="return confirm('Are you sure you want to withdraw from this course?')">
                            Withdraw from Course
                        </button>
                    </form>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('student.units') }}" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Proceed to Unit Registration
                    </a>
                </div>
            @else
                <form action="{{ route('student.enroll') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Course to Enroll In
                        </label>
                        <select id="course_id" name="course_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select a Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->course_code }} - {{ $course->title }} ({{ $course->credit_hours }} credits)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enroll in Course
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection