<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunat_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->string('ruc', 11);
            $table->string('commercial_name')->nullable();
            $table->string('address')->nullable();
            $table->string('ubigeo', 6)->nullable();
            $table->string('boleta_series', 4)->default('B001');
            $table->string('factura_series', 4)->default('F001');
            $table->string('nota_credito_series', 4)->default('FC01');
            $table->string('ose_provider', 30)->default('demo');
            $table->string('ose_api_url')->nullable();
            $table->text('ose_api_token')->nullable();
            $table->boolean('is_production')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunat_settings');
    }
};
