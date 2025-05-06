<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->decimal('cat_marks', 5, 2)->nullable();
        $table->decimal('exam_marks', 5, 2)->nullable();
        $table->string('grade')->nullable();
        $table->text('comments')->nullable();
    });
}

public function down()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->dropColumn(['cat_marks', 'exam_marks', 'grade', 'comments']);
    });
}

};
