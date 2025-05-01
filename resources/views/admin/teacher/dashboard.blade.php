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
            <!-- Grade Management Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-blue-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Grade Management</h3>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-800 mb-3">Input Student Marks</h4>
                        <form id="selectStudentForm">
                            @csrf
                            <div class="mb-4">
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                                <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select a Student --</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="inputMarksBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Input Marks
                            </button>
                        </form>
                    </div>
                    
                    <!-- Marks Input Form (Initially Hidden) -->
                    <div id="marksFormContainer" class="hidden mt-6 border-t pt-6">
                        <h4 class="text-md font-medium text-gray-800 mb-3">Enter Marks for <span id="studentName"></span></h4>
                        <p class="text-sm text-gray-600 mb-4">Course: <span id="studentCourse"></span></p>
                        
                        <form id="marksForm" action="{{ route('teacher.grades.submit') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" id="marks_student_id">
                            
                            <div id="unitsContainer" class="space-y-4">
                                <!-- Units will be dynamically inserted here -->
                            </div>
                            
                            <div class="mt-6">
                                <label for="teacher_comment" class="block text-sm font-medium text-gray-700 mb-1">Teacher's Comment</label>
                                <textarea name="teacher_comment" id="teacher_comment" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Optional comment about the student's performance"></textarea>
                            </div>
                            
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" id="cancelMarksBtn" class="px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    Cancel
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Submit Marks
                                </button>
                            </div>
                        </form>
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



<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const inputMarksBtn = document.getElementById('inputMarksBtn');
    const marksFormContainer = document.getElementById('marksFormContainer');
    const cancelMarksBtn = document.getElementById('cancelMarksBtn');
    const unitsContainer = document.getElementById('unitsContainer');
    const studentNameElement = document.getElementById('studentName');
    const studentCourseElement = document.getElementById('studentCourse');
    const marksStudentId = document.getElementById('marks_student_id');
    
    // Enable/disable input marks button based on selection
    studentSelect.addEventListener('change', function() {
        inputMarksBtn.disabled = !this.value;
    });
    
    // Handle input marks button click
    inputMarksBtn.addEventListener('click', function() {
        const studentId = studentSelect.value;
        
        if (!studentId) return;
        
        fetch(`/teacher/student-details/${studentId}`, {
    headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
})
.then(response => {
    if (!response.ok) {
        return response.json().then(err => { 
            throw new Error(err.error || 'Request failed with status ' + response.status); 
        });
    }
    return response.json();
})
.then(data => {
    if (!data.student) throw new Error('Student data not found');
    
    // Populate student info
    studentNameElement.textContent = data.student.name;
    studentCourseElement.textContent = data.student.course?.name || 'No course assigned';
    marksStudentId.value = data.student.id;
    
    // Clear previous units
    unitsContainer.innerHTML = '';
    
    // Add units to the form
    if (data.units && data.units.length > 0) {
        data.units.forEach(unit => {
            const unitDiv = document.createElement('div');
            unitDiv.className = 'bg-gray-50 p-4 rounded-md';
            unitDiv.innerHTML = `
                <h5 class="font-medium text-gray-800 mb-2">${unit.name} (${unit.code})</h5>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="unit_${unit.id}_cat" class="block text-sm font-medium text-gray-700 mb-1">CAT Marks</label>
                        <input type="number" name="units[${unit.id}][cat]" id="unit_${unit.id}_cat" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               min="0" max="30" placeholder="0-30">
                    </div>
                    <div>
                        <label for="unit_${unit.id}_exam" class="block text-sm font-medium text-gray-700 mb-1">Exam Marks</label>
                        <input type="number" name="units[${unit.id}][exam]" id="unit_${unit.id}_exam" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               min="0" max="70" placeholder="0-70">
                    </div>
                </div>
            `;
            unitsContainer.appendChild(unitDiv);
        });
    } else {
        unitsContainer.innerHTML = '<p class="text-gray-500">This student is not enrolled in any of your units.</p>';
    }
    
    marksFormContainer.classList.remove('hidden');
})
.catch(error => {
    console.error('Error:', error);
    alert(error.message || 'Failed to load student details. Please try again.');
});
    });
    
    // Handle cancel button
    cancelMarksBtn.addEventListener('click', function() {
        marksFormContainer.classList.add('hidden');
    });
    
    // Handle form submission
    document.getElementById('marksForm').addEventListener('submit', function(e) {
        // You could add form validation here if needed
    });
    
    // Show success/error messages
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection