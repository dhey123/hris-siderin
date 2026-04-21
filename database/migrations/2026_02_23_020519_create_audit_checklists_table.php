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
    Schema::create('audit_checklists', function (Blueprint $table) {
        $table->id();
        $table->string('kode')->nullable();
        $table->string('item');
        $table->text('standar')->nullable();
        $table->string('kategori')->nullable();
        $table->boolean('aktif')->default(1);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_checklists');
    }
};
