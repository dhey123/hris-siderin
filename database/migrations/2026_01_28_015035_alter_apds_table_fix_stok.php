<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('apds', function (Blueprint $table) {

        // TAMBAH KOLOM BARU (BELUM ADA)
        if (!Schema::hasColumn('apds', 'tanggal_pengadaan')) {
            $table->date('tanggal_pengadaan')->nullable()->after('keterangan');
        }

        // HAPUS KOLOM LAMA (KALAU ADA)
        if (Schema::hasColumn('apds', 'stok')) {
            $table->dropColumn('stok');
        }

        if (Schema::hasColumn('apds', 'status')) {
            $table->dropColumn('status');
        }

        if (Schema::hasColumn('apds', 'tanggal')) {
            $table->dropColumn('tanggal');
        }
    });
    }

    public function down(): void
{
    Schema::table('apds', function (Blueprint $table) {

        // BALIKIN KOLOM LAMA
        $table->integer('stok')->nullable()->after('department');
        $table->enum('status', ['Terkirim', 'Ditangani', 'Selesai'])
              ->default('Terkirim')
              ->after('tanggal');
        $table->date('tanggal')->nullable()->after('keterangan');

        // HAPUS KOLOM BARU
        $table->dropColumn('tanggal_pengadaan');

        });
    }
};
