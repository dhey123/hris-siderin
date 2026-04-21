<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctor_letters', function (Blueprint $table) {
            $table->id();

            // Relasi ke karyawan
            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke cuti (leave_requests)
            $table->foreignId('leave_request_id')
                ->nullable()
                ->constrained('leave_requests')
                ->nullOnDelete();

            // Data surat dokter
            $table->date('tanggal_surat');
            $table->string('diagnosa')->nullable();

            $table->integer('hari_istirahat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->string('nama_dokter')->nullable();
            $table->string('klinik')->nullable();

            // File surat dokter (PDF/JPG)
            $table->string('file_surat')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_letters');
    }
};
