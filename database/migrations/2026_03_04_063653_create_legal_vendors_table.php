<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_vendor');
            $table->string('jenis_vendor')->nullable(); // Limbah, Asuransi, Leasing, dll
            $table->string('npwp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak_person')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('Aktif')->index(); // Aktif / Nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_vendors');
    }
};