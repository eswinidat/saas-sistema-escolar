<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_concept_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->date('due_date');
            $table->string('status', 30)->default('pending');
            $table->string('period_label')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index(['due_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_charges');
    }
};
