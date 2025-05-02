<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentGradeController extends Controller
{
    /**
     * Display a listing of the student's grades
     */
    public function index()
    {
        $grades = Grade::with(['unit:id,title', 'teacher:id,name'])
            ->where('student_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.grades.index', compact('grades'));
    }

    /**
     * Download a grade file
     */
    public function download(Grade $grade)
    {
        // Verify the grade belongs to the authenticated student
        if ($grade->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!file_exists(storage_path('app/' . $grade->file_path))) {
            return back()->with('error', 'Grade file not found.');
        }

        return response()->download(storage_path('app/' . $grade->file_path));
    }

    /**
     * View a grade file
     */
    public function view(Grade $grade)
    {
        // Verify the grade belongs to the authenticated student
        if ($grade->student_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!file_exists(storage_path('app/' . $grade->file_path))) {
            return back()->with('error', 'Grade file not found.');
        }

        return response()->file(storage_path('app/' . $grade->file_path));
    }

    /**
     * Download all grades as PDF
     */
    public function downloadAll()
    {
        $grades = Grade::with(['unit:id,title', 'teacher:id,name'])
            ->where('student_id', Auth::id())
            ->latest()
            ->get();

        if ($grades->isEmpty()) {
            return back()->with('error', 'No grades available to download.');
        }

        $pdf = \PDF::loadView('student.grades.pdf', [
            'grades' => $grades,
            'student' => Auth::user(),
            'date' => now()->format('F d, Y')
        ]);

        return $pdf->download('all-grades.pdf');
    }
} 