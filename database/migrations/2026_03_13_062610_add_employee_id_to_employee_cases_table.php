<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_cases', function (Blueprint $table) {

            $table->foreignId('employee_id')
                  ->after('id')
                  ->constrained('employees')
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('employee_cases', function (Blueprint $table) {

            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');

        });
    }
};