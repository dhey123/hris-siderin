<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Identitas utama
            $table->string('employee_code')->unique();      // Kode karyawan
            $table->string('full_name');                    // Nama lengkap
            $table->enum('gender', ['L', 'P']);             // Jenis kelamin
            $table->date('birth_date')->nullable();         // Tanggal lahir

            // Kontak
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();

            // Dokumen identitas
            $table->string('nik_ktp')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bpjs_tk')->nullable();
            $table->string('bpjs_kes')->nullable();
            $table->text('alamat')->nullable();

            // HRIS spesifik (Quantum, Uniland, Borongan)
            $table->enum('company_type', ['Quantum', 'Uniland', 'Borongan'])->nullable();

            // Jenis pekerjaan (Staff, Produksi)
            $table->enum('employment_type', ['Staff', 'Produksi'])->nullable();

            // Relasi departemen & posisi
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();

            // Status kerja
            $table->enum('status', ['Active', 'Inactive', 'Resign'])->default('Active');

            // Upload file
            $table->string('photo')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('certificate_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
