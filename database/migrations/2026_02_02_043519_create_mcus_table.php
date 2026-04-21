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
        Schema::create('mcus', function (Blueprint $table) {
    $table->id();

    $table->foreignId('employee_id')
          ->nullable()
          ->constrained('employees')
          ->nullOnDelete();

    $table->enum('jenis_mcu', ['Awal', 'Berkala']);
    $table->date('tanggal_mcu');

    $table->enum('hasil', ['Fit', 'Unfit', 'Fit Dengan Catatan'])
          ->nullable();

    $table->string('klinik')->nullable();
    $table->text('catatan')->nullable();
    $table->string('file_hasil')->nullable();

    $table->timestamps();});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcus');
    }
};
