<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('legal_contracts', function (Blueprint $table) {

            // Kalau vendor_id mau dibuat nullable
            $table->foreignId('vendor_id')
                ->nullable()
                ->change();

            // Tambah jenis kontrak
            if (!Schema::hasColumn('legal_contracts', 'jenis')) {
                $table->enum('jenis', [
                    'Kontrak',
                    'MoU',
                    'Perjanjian'
                ])->default('Kontrak')->after('nama_kontrak');
            }

            // Ubah nomor_kontrak jadi unique kalau belum
            $table->string('nomor_kontrak')->unique()->change();

            // Upgrade nilai kontrak
            $table->decimal('nilai_kontrak', 18, 2)
                ->nullable()
                ->change();

            // Tambah keterangan kalau belum ada
            if (!Schema::hasColumn('legal_contracts', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }

            // Tambah soft delete kalau belum ada
            if (!Schema::hasColumn('legal_contracts', 'deleted_at')) {
                $table->softDeletes();
            }

        });
    }

    public function down(): void
    {
        Schema::table('legal_contracts', function (Blueprint $table) {

            $table->dropColumn('jenis');
            $table->dropColumn('keterangan');
            $table->dropSoftDeletes();

        });
    }
};