<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pelatihans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pelatihan', 150);
        $table->date('tanggal');
        $table->string('durasi', 50);
        $table->string('department', 100)->nullable();
        $table->text('keterangan')->nullable();
        $table->enum('status', ['Jadwal dibuat', 'Selesai', 'Dibatalkan'])
              ->default('Jadwal dibuat');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihans');
    }
};
