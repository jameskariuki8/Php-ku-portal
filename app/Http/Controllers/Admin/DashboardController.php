<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Unit;
use App\Models\StudentCourseEnrollment;
use App\Models\StudentUnitRegistration;
use App\Models\Grade;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total registered students
        $totalStudents = User::where('role', 'student')->count();

        // Active courses (all courses in database)
        $activeCourses = Course::count();

        // Total course units
        $courseUnits = Unit::count();

        // New registrations (students who registered in the last 7 days)
        $newRegistrations = StudentCourseEnrollment::where('created_at', '>=', Carbon::now()->subDays(7))->count();

        // Recent activities from all users
        $recentActivities = collect();

        // Get recent student registrations
        $studentRegistrations = StudentUnitRegistration::with(['enrollment.student', 'unit'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($registration) {
                return [
                    'type' => 'student',
                    'icon' => 'fa-user-plus',
                    'color' => 'indigo',
                    'title' => 'New Unit Registration',
                    'description' => $registration->enrollment->student->name . ' registered for ' . $registration->unit->title,
                    'time' => $registration->created_at->diffForHumans()
                ];
            });

        // Get recent grade submissions
        $gradeSubmissions = Grade::with(['student', 'unit'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($grade) {
                return [
                    'type' => 'teacher',
                    'icon' => 'fa-check-circle',
                    'color' => 'green',
                    'title' => 'Grade Submitted',
                    'description' => 'Grades submitted for ' . $grade->student->name . ' in ' . $grade->unit->title,
                    'time' => $grade->created_at->diffForHumans()
                ];
            });

        // Get recent course/unit additions
        $courseAdditions = Course::with('units')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($course) {
                return [
                    'type' => 'admin',
                    'icon' => 'fa-book',
                    'color' => 'blue',
                    'title' => 'New Course Added',
                    'description' => $course->title . ' with ' . $course->units->count() . ' units',
                    'time' => $course->created_at->diffForHumans()
                ];
            });

        // Combine and sort all activities by time
        $recentActivities = $recentActivities
            ->concat($studentRegistrations)
            ->concat($gradeSubmissions)
            ->concat($courseAdditions)
            ->sortByDesc('time')
            ->take(5);

        return view('admin.dashboard', compact(
            'totalStudents',
            'activeCourses',
            'courseUnits',
            'newRegistrations',
            'recentActivities'
        ));
    }
} 