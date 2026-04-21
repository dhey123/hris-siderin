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
    Schema::create('audit_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('audit_id')->constrained()->onDelete('cascade');
        $table->foreignId('audit_checklist_id')->constrained()->onDelete('cascade');

        $table->enum('hasil', ['sesuai','tidak_sesuai','observasi'])->nullable();
        $table->text('temuan')->nullable();
        $table->text('tindak_lanjut')->nullable();
        $table->date('target_selesai')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_details');
    }
};
