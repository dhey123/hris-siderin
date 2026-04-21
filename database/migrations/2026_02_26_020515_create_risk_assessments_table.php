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
        Schema::create('risk_assessments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('risk_id')->constrained()->onDelete('cascade');
    $table->enum('likelihood', ['Low','Medium','High']);
    $table->enum('impact', ['Minor','Major','Critical']);
    $table->integer('risk_score');
    $table->enum('risk_level', ['Low','Medium','High']);
    $table->string('assessed_by')->nullable();
    $table->timestamp('assessed_at')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
