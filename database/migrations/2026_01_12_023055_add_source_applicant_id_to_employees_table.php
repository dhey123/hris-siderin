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
    Schema::table('employees', function (Blueprint $table) {
        $table->foreignId('source_applicant_id')
              ->nullable()
              ->unique()
              ->after('id')
              ->constrained('recruitment_applicants')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropForeign(['source_applicant_id']);
        $table->dropColumn('source_applicant_id');
    });

    }
};
