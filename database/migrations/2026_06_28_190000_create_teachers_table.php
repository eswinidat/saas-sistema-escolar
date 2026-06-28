<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('document_type', 20)->default('DNI');
            $table->string('document_number', 20);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('specialty')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('status', 30)->default('active');
            $table->timestamps();

            $table->unique(['school_id', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
