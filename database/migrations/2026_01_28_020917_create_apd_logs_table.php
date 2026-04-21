<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apd_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('apd_id')
                  ->constrained('apds')
                  ->cascadeOnDelete();

            $table->string('dipakai_oleh')->nullable(); // nanti bisa karyawan
            $table->integer('jumlah');                  // jumlah dipakai
            $table->date('tanggal')->default(now());
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apd_logs');
    }
};
