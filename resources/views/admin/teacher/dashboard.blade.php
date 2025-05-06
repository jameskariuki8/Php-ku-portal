@extends('layouts.teacher')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="mt-2 text-indigo-100">Here's what's happening in your classroom today</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="h-24 w-24 text-indigo-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Enrolled Students</h3>
                            <p class="mt-1 text-3xl font-bold text-indigo-600">{{ $studentCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.teacher.students') }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-900 transition duration-300">
                        View Students
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Units Assigned</h3>
                            <p class="mt-1 text-3xl font-bold text-green-600">{{ $unitCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.teacher.units') }}" class="mt-4 inline-flex items-center text-green-600 hover:text-green-900 transition duration-300">
                        View Units
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transform transition duration-500 hover:scale-105">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Grades Submitted</h3>
                            <p class="mt-1 text-3xl font-bold text-purple-600">{{ $gradeCount }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.teacher.grades') }}" class="mt-4 inline-flex items-center text-purple-600 hover:text-purple-900 transition duration-300">
                        View Grades
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('admin.teacher.students') }}" class="p-6 border rounded-lg hover:bg-gray-50 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Manage Students</h4>
                                <p class="mt-1 text-sm text-gray-500">View and manage enrolled students</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.teacher.students') }}" class="p-6 border rounded-lg hover:bg-gray-50 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Input Grades</h4>
                                <p class="mt-1 text-sm text-gray-500">Submit and manage student grades</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.teacher.units') }}" class="p-6 border rounded-lg hover:bg-gray-50 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Manage Units</h4>
                                <p class="mt-1 text-sm text-gray-500">Create and manage course units</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="p-6 border rounded-lg hover:bg-gray-50 transform transition duration-300 hover:scale-105">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Update Profile</h4>
                                <p class="mt-1 text-sm text-gray-500">Manage your account settings</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function showGradeForm(studentId) {
    document.getElementById('student_id').value = studentId;
    document.getElementById('gradeFormModal').classList.remove('hidden');
    
    // Fetch student details and populate units
    fetch(`/teacher/student-details/${studentId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        const unitsContainer = document.getElementById('unitsContainer');
        unitsContainer.innerHTML = '';
        
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
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load student details. Please try again.');
    });
}

function closeGradeForm() {
    document.getElementById('gradeFormModal').classList.add('hidden');
}
</script>
@endsection