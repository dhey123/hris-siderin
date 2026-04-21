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
    Schema::create('ga_maintenances', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')->constrained('ga_assets')->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();

        $table->enum('status', ['pending', 'process', 'done'])->default('pending');

        $table->date('report_date')->nullable();
        $table->date('finish_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ga_maintenances');
    }
};
