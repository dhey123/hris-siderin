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
        Schema::create('apds', function (Blueprint $table) {
    $table->id();
    $table->string('nama_apd');
    $table->string('jenis_apd');
    $table->integer('stok')->default(0);
    $table->enum('kondisi', ['Baik', 'Rusak', 'Hilang'])->default('Baik');
    $table->text('keterangan')->nullable();
    $table->date('tanggal')->default(DB::raw('CURRENT_DATE'));
    $table->enum('status', ['Terkirim', 'Ditangani', 'Selesai'])->default('Terkirim');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apds');
    }
};
