<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GradeNotification;
use Illuminate\Support\Facades\Storage;

class GradeController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'unit_id' => 'required|exists:units,id',
            'grade_file' => 'required|mimes:pdf|max:2048'
        ]);
        
        // Store the file
        $path = $request->file('grade_file')->store('grades');
        
        // Create grade record
        $grade = Grade::create([
            'teacher_id' => auth()->id(),
            'student_id' => $request->student_id,
            'unit_id' => $request->unit_id,
            'file_path' => $path,
            'uploaded_at' => now()
        ]);
        
        return back()->with('success', 'Grade uploaded successfully!');
    }
    
    public function send(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'message' => 'nullable|string'
        ]);
        
        $grade = Grade::with(['student', 'unit'])->find($request->grade_id);
        
        // Send email to student
        Mail::to($grade->student->email)->send(new GradeNotification($grade, $request->message));
        
        return back()->with('success', 'Grade sent to student successfully!');
    }

    public function download(Grade $grade)
{
    // Check if student is authorized to access this grade
    if ($grade->student_id != auth()->id()) {
        abort(403);
    }
    
    return Storage::download($grade->file_path, 'grade_' . $grade->unit->code . '.pdf');
}

public function view(Grade $grade)
{
    // Check if student is authorized to access this grade
    if ($grade->student_id != auth()->id()) {
        abort(403);
    }
    
    return response()->file(storage_path('app/' . $grade->file_path));
}
}