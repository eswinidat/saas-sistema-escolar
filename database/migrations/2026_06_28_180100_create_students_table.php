<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('document_type', 20)->default('DNI');
            $table->string('document_number', 20);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('status', 30)->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['school_id', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
