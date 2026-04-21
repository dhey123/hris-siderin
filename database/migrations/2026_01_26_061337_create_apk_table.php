<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat'); // Nama APK, misal Helm, Sepatu Safety
            $table->string('lokasi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->enum('kondisi', ['Baik','Rusak','Perlu Maintenance'])->default('Baik');
            $table->string('owner')->nullable(); // PIC / departemen
            $table->date('tanggal_update')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apk');
    }
};
