<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\GradeController; // Make sure to add this
use App\Http\Controllers\students\StudentEnrollmentController;
use App\Http\Controllers\students\UnitRegistrationController;
use App\Http\Controllers\students\StudentGradeController; // Add this for student grades

// Home Route
Route::get('/', function () {
    return view('welcome');
});



// Authenticated Routes
Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard Route
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('admin.dashboard');
    
    // Teacher Dashboard Route
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])
        ->name('admin.teacher.dashboard');
        Route::get('/teacher/student-details/{student}', [TeacherController::class, 'getStudentDetails'])
    ->middleware('auth:teacher');

    // Student Dashboard Route
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->middleware(['auth', 'verified'])->name('student.dashboard');

    Route::prefix('admin')->group(function () {
        // Teacher routes
        Route::get('/teacher/add', [TeacherController::class, 'create'])->name('admin.teacher.add');
        Route::post('/teacher/add', [TeacherController::class, 'store']);
        Route::get('/teacher', [TeacherController::class, 'index'])->name('admin.teacher.view');
        
        // Course routes
        Route::get('/courses/add', [CourseController::class, 'create'])->name('admin.courses.add');
        Route::post('/courses/add', [CourseController::class, 'store']);
        Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses.view');
    });

    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware(['auth', 'verified'])->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [VerifiedController::class, 'verify'])->middleware(['auth'])->name('verification.verify');
});
// Teacher routes group
Route::prefix('teacher')->group(function () {
    // Units management
    Route::get('/units', [UnitController::class, 'index'])->name('admin.teacher.units');
    Route::get('/units/create', [UnitController::class, 'create'])->name('admin.teacher.units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('admin.teacher.units.store');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('admin.teacher.units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('admin.teacher.units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('admin.teacher.units.destroy');
    
    // Students management
    Route::get('/students', [TeacherController::class, 'students'])->name('admin.teacher.students');
    
    // Grades management
    Route::get('/grades', [GradeController::class, 'index'])->name('admin.teacher.grades');
    
    // Grade management routes
    Route::get('/student-details/{student}', [TeacherController::class, 'getStudentDetails'])
        ->name('teacher.student.details');
        
    Route::post('/grades/submit', [TeacherController::class, 'submitGrades'])
        ->name('teacher.grades.submit');
        
    Route::post('/grades/upload', [GradeController::class, 'upload'])
        ->name('teacher.grades.upload');
        
    Route::post('/grades/send', [GradeController::class, 'send'])
        ->name('teacher.grades.send');
        
    Route::get('/units/{student}', [TeacherController::class, 'getStudentUnits'])
        ->name('admin.teacher.units.student');
});

// Student routes group
Route::prefix('student')->group(function () {
    // Enrollment routes
    Route::get('/enroll', [StudentEnrollmentController::class, 'index'])
        ->name('student.enroll');
    Route::post('/enroll', [StudentEnrollmentController::class, 'store']);
    Route::delete('/student/enroll/{enrollment}', [StudentEnrollmentController::class, 'destroy'])
    ->name('student.enroll.destroy');

    
    // Unit registration routes
    Route::get('/units', [UnitRegistrationController::class, 'index'])
        ->name('student.units.index');
    Route::post('/units', [UnitRegistrationController::class, 'store'])
        ->name('student.units.store');
    Route::delete('/units/{unitId}', [UnitRegistrationController::class, 'destroy'])
        ->name('student.units.destroy');

    // Grade viewing routes
    Route::get('/grades', [StudentGradeController::class, 'index'])
        ->name('student.grades.index');
    Route::get('/grades/{grade}/download', [StudentGradeController::class, 'download'])
        ->name('student.grades.download');
    Route::get('/grades/{grade}/view', [StudentGradeController::class, 'view'])
        ->name('student.grades.view');
    Route::get('/grades/download-all', [StudentGradeController::class, 'downloadAll'])
        ->name('student.grades.download-all');
});

require __DIR__.'/auth.php';