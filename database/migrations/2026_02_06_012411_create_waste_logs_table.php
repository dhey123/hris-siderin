<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_id')->constrained('wastes')->onDelete('cascade'); // relasi ke master limbah
            $table->enum('tipe_log', ['Masuk','Keluar']);
            $table->decimal('jumlah',10,2);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_logs');
    }
};
