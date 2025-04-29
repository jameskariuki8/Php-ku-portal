@extends('layouts.teacher')

@section('title', 'Edit Unit')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Unit</h2>
            
            <form action="{{ route('teacher.units.update', $unit) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                        <select id="course_id" name="course_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $unit->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->title }} ({{ $course->course_code }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Unit Title</label>
                        <input type="text" id="title" name="title" value="{{ $unit->title }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $unit->description }}</textarea>
                    </div>
                    
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                        <input type="number" id="order" name="order" min="0" value="{{ $unit->order }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Determines the sequence of units in the course</p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('teacher.units') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection