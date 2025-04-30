<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;  
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\students\StudentEnrollmentController;
use App\Http\Controllers\students\UnitRegistrationController;

// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/teacher/dashboard', function () {
        return view('admin.teacher.dashboard');
    })->middleware(['auth', 'verified'])->name('admin.teacher.dashboard');
    
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

// Teacher routes
Route::middleware(['auth'])->prefix('teacher')->group(function () {
    

    // Units management
    Route::get('/units', [UnitController::class, 'index'])->name('admin.teacher.units');
    Route::get('/units/create', [UnitController::class, 'create'])->name('admin.teacher.units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('admin.teacher.units.store');
    Route::get('/units/{unit}/edit', [UnitController::class, 'edit'])->name('admin.teacher.units.edit');
    Route::put('/units/{unit}', [UnitController::class, 'update'])->name('admin.teacher.units.update');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('admin.teacher.units.destroy');
});

// routes/web.php
Route::middleware('auth')->prefix('student')->group(function () {
    // Enrollment routes
    Route::get('/enroll', [\App\Http\Controllers\students\StudentEnrollmentController::class, 'index'])
        ->name('student.enroll');
    Route::post('/enroll', [\App\Http\Controllers\students\StudentEnrollmentController::class, 'store']);
    Route::delete('/enroll/{enrollment}', [\App\Http\Controllers\students\StudentEnrollmentController::class, 'destroy']);
    
    // Unit registration routes
    Route::get('/units', [\App\Http\Controllers\students\UnitRegistrationController::class, 'index'])
        ->name('student.units');
    Route::post('/units', [\App\Http\Controllers\students\UnitRegistrationController::class, 'store']);
    Route::delete('/units/{registration}', [\App\Http\Controllers\students\UnitRegistrationController::class, 'destroy']);
});

require __DIR__.'/auth.php';
