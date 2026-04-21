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
        Schema::create('legal_compliances', function (Blueprint $table) {
    $table->id();
    $table->string('nama_compliance'); // NIB, ISO, SIUP dll
    $table->string('nomor')->nullable();
    $table->date('tanggal_terbit')->nullable();
    $table->date('tanggal_berakhir')->nullable()->index();
    $table->string('file_path')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_compliances');
    }
};
