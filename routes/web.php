<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TeacherController;  
use Illuminate\Support\Facades\Route;

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
        return view('teacher.dashboard');
    })->middleware(['auth', 'verified'])->name('teacher.dashboard');
    
    // Student Dashboard Route
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->middleware(['auth', 'verified'])->name('student.dashboard');

    // Admin Teacher Registration Routes
    Route::get('/admin/register-teacher', [TeacherController::class, 'create'])->name('admin.register-teacher')->middleware(['auth', 'verified']);
    Route::post('/admin/register-teacher', [TeacherController::class, 'store'])->name('admin.store-teacher')->middleware(['auth', 'verified']);

    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware(['auth', 'verified'])->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [VerifiedController::class, 'verify'])->middleware(['auth'])->name('verification.verify');
});

require __DIR__.'/auth.php';
