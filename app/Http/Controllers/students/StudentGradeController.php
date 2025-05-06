<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;


class StudentGradeController extends Controller
{
    // Display a listing of the student's grades
     
    public function index()
    {
        $grades = Grade::with(['unit:id,title', 'teacher:id,name'])
            ->where('student_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('student.grades.index', compact('grades'));
    }

    // Download a grade file
     
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

    // View a grade file
     
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

    //Download all grades as Csv
    public function downloadAll()
    {
        $grades = Grade::where('student_id', Auth::id())->with('unit')->get();
    
        if ($grades->isEmpty()) {
            return back()->with('error', 'No grades available to download.');
        }
    
        $response = new StreamedResponse(function () use ($grades) {
            $handle = fopen('php://output', 'w');
    
            // CSV headers
            fputcsv($handle, ['Unit Title', 'CAT Marks', 'Exam Marks', 'Final Grade']);
    
            // CSV rows
            foreach ($grades as $grade) {
                fputcsv($handle, [
                    $grade->unit->title,
                    $grade->cat_marks ?? 'N/A',
                    $grade->exam_marks ?? 'N/A',
                    $grade->grade
                ]);
            }
    
            fclose($handle);
        });
    
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="all-grades.csv"');
    
        return $response;
    }
} 