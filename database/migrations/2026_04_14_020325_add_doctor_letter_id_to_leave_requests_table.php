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
    Schema::table('leave_requests', function (Blueprint $table) {
        $table->foreignId('doctor_letter_id')
              ->nullable()
              ->constrained('doctor_letters')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('leave_requests', function (Blueprint $table) {
        $table->dropForeign(['doctor_letter_id']);
        $table->dropColumn('doctor_letter_id');
    });

    }
};
