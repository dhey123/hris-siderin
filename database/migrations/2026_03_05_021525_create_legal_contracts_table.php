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
        Schema::create('legal_contracts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendor_id')->constrained('legal_vendors')->cascadeOnDelete();
    $table->string('nama_kontrak');
    $table->string('nomor_kontrak')->nullable();
    $table->date('tanggal_mulai');
    $table->date('tanggal_berakhir')->index();
    $table->decimal('nilai_kontrak', 15, 2)->nullable();
    $table->string('file_path')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_contracts');
    }
};
