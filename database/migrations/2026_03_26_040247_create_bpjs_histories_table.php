<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bpjs_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bpjs_record_id')->constrained()->cascadeOnDelete();

            $table->enum('bpjs_kesehatan', ['paid', 'unpaid']);
            $table->enum('bpjs_ketenagakerjaan', ['paid', 'unpaid']);

            $table->timestamp('tanggal_bayar')->nullable();
            $table->string('updated_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bpjs_histories');
    }
};