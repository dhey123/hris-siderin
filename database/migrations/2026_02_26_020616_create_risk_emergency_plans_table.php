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
        Schema::create('risk_emergency_plans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('risk_id')->constrained()->onDelete('cascade');
    $table->text('rencana');
    $table->string('contact_person')->nullable();
    $table->text('catatan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_emergency_plans');
    }
};
