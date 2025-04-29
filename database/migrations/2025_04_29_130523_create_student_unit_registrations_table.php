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
       // database/migrations/YYYY_MM_DD_create_student_unit_registrations_table.php
Schema::create('student_unit_registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('enrollment_id')->constrained('student_course_enrollments')->onDelete('cascade');
    $table->foreignId('unit_id')->constrained()->onDelete('cascade');
    $table->date('registration_date');
    $table->enum('status', ['registered', 'completed', 'dropped'])->default('registered');
    $table->timestamps();
    
    $table->unique(['enrollment_id', 'unit_id']); // Prevent duplicate unit registrations
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_unit_registrations');
    }
};
