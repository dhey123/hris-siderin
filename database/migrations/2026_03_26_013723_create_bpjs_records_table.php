<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
                Schema::create('bpjs_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            $table->integer('bulan');
            $table->integer('tahun');

            $table->enum('bpjs_kesehatan', ['paid', 'unpaid'])->default('unpaid');
            $table->enum('bpjs_ketenagakerjaan', ['paid', 'unpaid'])->default('unpaid');

            $table->date('tanggal_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();

            $table->timestamps();

            $table->unique(['employee_id', 'bulan', 'tahun']); // biar gak double
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpjs_records');
    }
};
