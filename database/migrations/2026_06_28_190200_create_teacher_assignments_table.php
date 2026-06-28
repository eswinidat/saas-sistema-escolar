<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('hours_per_week')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['teacher_id', 'course_id', 'section_id', 'academic_year_id'], 'teacher_assignment_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_assignments');
    }
};
