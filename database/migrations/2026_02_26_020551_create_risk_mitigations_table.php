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
        Schema::create('risk_mitigations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('risk_id')->constrained()->onDelete('cascade');
    $table->text('tindakan');
    $table->string('pic')->nullable();
    $table->date('deadline')->nullable();
    $table->enum('status', ['Planned','Ongoing','Done'])->default('Planned');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_mitigations');
    }
};
