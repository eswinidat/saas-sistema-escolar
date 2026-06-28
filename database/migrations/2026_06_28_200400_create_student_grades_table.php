<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grading_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('competency_id')->constrained()->cascadeOnDelete();
            $table->foreignId('capability_id')->nullable()->constrained()->nullOnDelete();
            $table->string('achievement_level', 5)->nullable();
            $table->decimal('numeric_grade', 5, 2)->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'grading_period_id', 'competency_id', 'capability_id'], 'student_grade_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
