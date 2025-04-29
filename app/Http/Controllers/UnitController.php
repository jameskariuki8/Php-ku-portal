<?php
// app/Http/Controllers/UnitController.php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::where('teacher_id', Auth::id())
            ->with('course')
            ->latest()
            ->get();

        return view('admin.teacher.units.index', compact('units'));
    }

    public function create()
{
    $courses = Course::all();
    $units = Unit::where('teacher_id', Auth::id())->with('course')->latest()->get();

    return view('admin.teacher.units.create', compact('courses', 'units'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $validated['teacher_id'] = Auth::id();

        Unit::create($validated);

        return redirect()->route('admin.teacher.units')
            ->with('success', 'Unit created successfully!');
    }

    public function edit(Unit $unit)
    {
        $courses = Course::all();
        return view('admin.teacher.units.edit', compact('unit', 'courses'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $unit->update($validated);

        return redirect()->route('admin.teacher.units')
            ->with('success', 'Unit updated successfully!');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.teacher.units')
            ->with('success', 'Unit deleted successfully!');
    }
}