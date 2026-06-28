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
    Schema::create('schools', function (Blueprint $table) {

        $table->id();

        // Información general
        $table->string('name');
        $table->string('code')->nullable()->unique();
        $table->string('ruc', 11)->nullable()->unique();
        $table->string('modular_code')->nullable();

        // Contacto
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('website')->nullable();

        // Dirección
        $table->string('address')->nullable();
        $table->string('district')->nullable();
        $table->string('province')->nullable();
        $table->string('department')->nullable();

        // Director
        $table->string('principal_name')->nullable();

        // Logo
        $table->string('logo')->nullable();

        // Estado
        $table->boolean('status')->default(true);

        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
