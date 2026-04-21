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
    Schema::create('audits', function (Blueprint $table) {
        $table->id();
        $table->string('kode_audit')->unique();
        $table->string('jenis_audit'); // internal dulu
        $table->string('area');
        $table->date('tanggal_audit');
        $table->string('auditor');
        $table->enum('status', ['draft','selesai','followup'])->default('draft');
        $table->text('catatan')->nullable();
        $table->unsignedBigInteger('created_by');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
