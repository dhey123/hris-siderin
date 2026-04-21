<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Religion
        Schema::table('religions', function (Blueprint $table) {
            if (!Schema::hasColumn('religions', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Education
        Schema::table('educations', function (Blueprint $table) {
            if (!Schema::hasColumn('educations', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Marital Status
        Schema::table('marital_statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('marital_statuses', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Employment Status
        Schema::table('employment_statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('employment_statuses', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Employment Type
        Schema::table('employment_types', function (Blueprint $table) {
            if (!Schema::hasColumn('employment_types', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Banks
        Schema::table('banks', function (Blueprint $table) {
            if (!Schema::hasColumn('banks', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Departments
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Positions
        Schema::table('positions', function (Blueprint $table) {
            if (!Schema::hasColumn('positions', 'name')) {
                $table->string('name')->nullable();
            }
        });

        // Locations
        Schema::table('locations', function (Blueprint $table) {
            if (!Schema::hasColumn('locations', 'name')) {
                $table->string('name')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Dikosongkan supaya rollback aman
    }
};
