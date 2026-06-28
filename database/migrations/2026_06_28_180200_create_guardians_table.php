<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('document_type', 20)->default('DNI');
            $table->string('document_number', 20);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('occupation')->nullable();
            $table->boolean('is_economic_responsible')->default(false);
            $table->timestamps();

            $table->unique(['school_id', 'document_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
