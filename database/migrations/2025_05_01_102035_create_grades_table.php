<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('unit_id')->constrained();
            $table->string('file_path');
            $table->timestamp('uploaded_at');
            $table->decimal('cat_marks', 5, 2)->nullable();
            $table->decimal('exam_marks', 5, 2)->nullable();
            $table->string('grade')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
