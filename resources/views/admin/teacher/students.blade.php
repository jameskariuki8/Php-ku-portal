@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Students Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Enrolled Students</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered Units</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $student->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $student->enrollment->course->title ?? 'Not enrolled' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500">
                                                @if($student->enrollment && $student->enrollment->registeredUnits)
                                                    @foreach($student->enrollment->registeredUnits as $unit)
                                                        <span class="inline-block bg-gray-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                                                            {{ $unit->title }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    No units registered
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="showGradeForm({{ $student->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Input Grades
                                            </button>
                                            <a href="{{ route('teacher.student.details', $student) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No students enrolled in your units yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grade Input Form Modal -->
<div id="gradeFormModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Input Student Marks</h3>
            <form id="gradeForm" action="{{ route('teacher.grades.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="student_id">
                
                <div id="unitsContainer" class="space-y-4">
                    <!-- Units will be dynamically inserted here -->
                </div>
                
                <div class="mt-4">
                    <label for="teacher_comment" class="block text-sm font-medium text-gray-700 mb-1">Teacher's Comment</label>
                    <textarea name="teacher_comment" id="teacher_comment" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeGradeForm()" 
                            class="px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Submit Grades
                    </button>
                </div>
            </form>
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