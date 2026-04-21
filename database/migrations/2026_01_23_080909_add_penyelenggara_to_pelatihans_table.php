<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelatihans', function (Blueprint $table) {
            $table->string('penyelenggara')
                  ->nullable()
                  ->after('tanggal'); // sesuaikan kolom sebelumnya
        });
    }

    public function down(): void
    {
        Schema::table('pelatihans', function (Blueprint $table) {
            $table->dropColumn('penyelenggara');
        });
    }
};

