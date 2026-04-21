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
        Schema::create('incidents', function (Blueprint $table) {
    $table->id();

    $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

    $table->date('incident_date');
    $table->string('location')->nullable();
    $table->string('incident_type');
    $table->enum('severity', ['ringan', 'sedang', 'berat', 'fatal']);

    $table->text('description')->nullable();
    $table->text('action_taken')->nullable();

    $table->enum('status', ['open', 'investigation', 'closed'])->default('open');

    $table->string('attachment')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
