@extends('layouts.student')

@section('title', 'Unit Registration')
@section('header', 'Unit Registation')

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Unit Registration</h2>
                <div class="text-sm text-gray-600">
                    Enrolled in: <span class="font-medium">{{ $enrollment->course->title }}</span>
                </div>
            </div>
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Available Units -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Available Units</h3>
                    
                    @if($courseUnits->count() > 0)
                        <div class="space-y-3">
                            @foreach($courseUnits as $unit)
                                @if(!$registeredUnits->contains($unit))
                                    <div class="p-4 border border-gray-200 rounded-lg">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $unit->title }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($unit->description, 100) }}</p>
                                            </div>
                                            <form action="{{ route('student.units.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                                                    Register
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No units available for this course yet.</p>
                    @endif
                </div>
                
                <!-- Registered Units -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Registered Units</h3>
                    
                    @if($registeredUnits->count() > 0)
                        <div class="space-y-3">
                            @foreach($registeredUnits as $unit)
                                <div class="p-4 border border-gray-200 rounded-lg bg-blue-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $unit->title }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($unit->description, 100) }}</p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                Registered on: {{ \Carbon\Carbon::parse($unit->pivot->registration_date)->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <form action="{{ route('student.units.destroy', $unit->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" 
            class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200"
            onclick="return confirm('Are you sure you want to drop this unit?')">
        Drop Unit
    </button>
</form>
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">You haven't registered for any units yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection