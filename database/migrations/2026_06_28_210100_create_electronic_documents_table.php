<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('electronic_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('related_document_id')->nullable()->constrained('electronic_documents')->nullOnDelete();
            $table->string('document_type', 2);
            $table->string('series', 4);
            $table->unsignedInteger('number');
            $table->string('full_number')->unique();
            $table->date('issue_date');
            $table->string('currency', 3)->default('PEN');
            $table->string('customer_doc_type', 1)->default('1');
            $table->string('customer_doc_number', 15);
            $table->string('customer_name');
            $table->string('customer_address')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('igv', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status', 20)->default('draft');
            $table->text('sunat_response')->nullable();
            $table->string('sunat_hash')->nullable();
            $table->text('qr_data')->nullable();
            $table->string('xml_path')->nullable();
            $table->string('cdr_path')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['school_id', 'series', 'number', 'document_type'], 'electronic_docs_school_series_num_type_uniq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('electronic_documents');
    }
};
