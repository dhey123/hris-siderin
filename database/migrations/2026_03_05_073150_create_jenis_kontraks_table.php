<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_kontrak', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis')->unique();
            $table->timestamps();
        });

        // Tambah kolom foreign key di legal_contracts
        Schema::table('legal_contracts', function (Blueprint $table) {
            $table->foreignId('jenis_kontrak_id')->nullable()->after('nama_kontrak')->constrained('jenis_kontrak');
        });
    }

    public function down(): void
    {
        Schema::table('legal_contracts', function (Blueprint $table) {
            $table->dropForeign(['jenis_kontrak_id']);
            $table->dropColumn('jenis_kontrak_id');
        });

        Schema::dropIfExists('jenis_kontrak');
    }
};