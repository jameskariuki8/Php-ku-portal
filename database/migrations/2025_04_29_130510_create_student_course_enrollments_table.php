<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/YYYY_MM_DD_create_student_course_enrollments_table.php
Schema::create('student_course_enrollments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('course_id')->constrained()->onDelete('cascade');
    $table->date('enrollment_date');
    $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active');
    $table->timestamps();
    
    $table->unique(['student_id', 'course_id']); // A student can only enroll once per course
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_course_enrollments');
    }
};
