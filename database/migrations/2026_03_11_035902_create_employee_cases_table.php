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
        Schema::create('employee_cases', function (Blueprint $table) {
    $table->id();
    $table->string('nama_karyawan');
    $table->string('jenis_kasus');
    $table->date('tanggal');
    $table->text('kronologi')->nullable();
    $table->string('status')->default('Proses');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_cases');
    }
};
