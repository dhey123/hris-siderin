<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->string('kategori')->index(); // Perusahaan / Kendaraan / Vendor / Lainnya
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_berakhir')->nullable()->index();

            $table->foreignId('vendor_id')
                  ->nullable()
                  ->constrained('legal_vendors')
                  ->nullOnDelete();

            $table->string('file_path')->nullable();
            $table->string('status')->default('Aktif')->index(); // Aktif / Expired
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};