<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_inspeksi')->unique();
            $table->date('tanggal');
            $table->string('area');
            $table->string('jenis');
            $table->enum('kategori', ['Environment', 'Safety', 'Health']);
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Draft', 'Open', 'Closed'])->default('Draft');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
