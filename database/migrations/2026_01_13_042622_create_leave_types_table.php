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
    Schema::create('leave_types', function (Blueprint $table) {
        $table->id();

        $table->string('name'); 
        // Tahunan, Sakit, Menikah, dll

        $table->enum('category', ['cuti', 'izin']);
        // cuti = potong kuota, izin = biasanya tidak

        $table->integer('default_quota')->nullable();
        // Tahunan = 12, Menikah = 3, Sakit = null

        $table->boolean('is_paid')->default(true);
        // dibayar / tidak

        $table->boolean('is_active')->default(true);

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
