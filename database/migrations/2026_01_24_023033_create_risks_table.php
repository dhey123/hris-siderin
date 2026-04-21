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
    Schema::create('risks', function (Blueprint $table) {
        $table->id();
        $table->string('nama_risiko');
        $table->text('deskripsi')->nullable();
        $table->enum('kategori', ['Safety', 'Health', 'Environment']);
        $table->enum('likelihood', ['Low', 'Medium', 'High']);
        $table->enum('impact', ['Minor', 'Major', 'Critical']);
        $table->text('mitigasi')->nullable();
        $table->string('owner')->nullable();
        $table->enum('status', ['Open', 'In Progress', 'Closed'])->default('Open');
        $table->date('tanggal_update')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
