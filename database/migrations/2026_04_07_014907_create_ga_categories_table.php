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
        Schema::create('ga_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ATK, Mesin, Properti
            $table->string('code')->nullable(); // ATK, MES, PRO (buat kode asset nanti 🔥)
            $table->string('color')->nullable(); // optional buat badge UI
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ga_categories');
    }
};