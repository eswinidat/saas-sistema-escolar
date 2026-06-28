<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_concepts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 30)->nullable();
            $table->string('type', 30)->default('pension');
            $table->decimal('default_amount', 10, 2)->default(0);
            $table->boolean('is_recurring')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['school_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_concepts');
    }
};
