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
    Schema::create('she', function (Blueprint $table) {
        $table->id();
        $table->string('modul');      // safety / health / environment
        $table->string('submodul');   // insiden / apd / mcu / audit / limbah / inspeksi
        $table->date('tanggal');       // tanggal catatan / kejadian
        $table->string('lokasi');      // lokasi / unit terkait
        $table->text('deskripsi');     // detail / keterangan
        $table->enum('status', ['Terkirim','Ditangani','Selesai'])->default('Terkirim');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('she');
    }
};
