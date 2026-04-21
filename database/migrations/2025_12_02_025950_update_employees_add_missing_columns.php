<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            if (!Schema::hasColumn('employees', 'mother_name')) {
                $table->string('mother_name')->nullable();
            }

            if (!Schema::hasColumn('employees', 'nik')) {
                $table->string('nik')->nullable();
            }

            if (!Schema::hasColumn('employees', 'npwp')) {
                $table->string('npwp')->nullable();
            }

            if (!Schema::hasColumn('employees', 'bpjs_kesehatan')) {
                $table->string('bpjs_kesehatan')->nullable();
            }

            if (!Schema::hasColumn('employees', 'bpjs_ketenagakerjaan')) {
                $table->string('bpjs_ketenagakerjaan')->nullable();
            }

            if (!Schema::hasColumn('employees', 'birth_place')) {
                $table->string('birth_place')->nullable();
            }

            if (!Schema::hasColumn('employees', 'religion_id')) {
                $table->unsignedBigInteger('religion_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'education_id')) {
                $table->unsignedBigInteger('education_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'marital_status_id')) {
                $table->unsignedBigInteger('marital_status_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'blood_type')) {
                $table->string('blood_type')->nullable();
            }

            if (!Schema::hasColumn('employees', 'address_ktp')) {
                $table->text('address_ktp')->nullable();
            }

            if (!Schema::hasColumn('employees', 'address_domisili')) {
                $table->text('address_domisili')->nullable();
            }

            if (!Schema::hasColumn('employees', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'level_id')) {
                $table->unsignedBigInteger('level_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'employment_type_id')) {
                $table->unsignedBigInteger('employment_type_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'employment_status_id')) {
                $table->unsignedBigInteger('employment_status_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'location_id')) {
                $table->unsignedBigInteger('location_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'exit_date')) {
                $table->date('exit_date')->nullable();
            }

            if (!Schema::hasColumn('employees', 'reason_resign')) {
                $table->string('reason_resign')->nullable();
            }

            if (!Schema::hasColumn('employees', 'emergency_name')) {
                $table->string('emergency_name')->nullable();
            }

            if (!Schema::hasColumn('employees', 'emergency_relation')) {
                $table->string('emergency_relation')->nullable();
            }

            if (!Schema::hasColumn('employees', 'emergency_phone')) {
                $table->string('emergency_phone')->nullable();
            }

            if (!Schema::hasColumn('employees', 'bank_id')) {
                $table->unsignedBigInteger('bank_id')->nullable();
            }

            if (!Schema::hasColumn('employees', 'bank_account')) {
                $table->string('bank_account')->nullable();
            }

            if (!Schema::hasColumn('employees', 'children_count')) {
                $table->unsignedTinyInteger('children_count')->default(0);
            }

        });
    }

    public function down(): void
    {
        // opsional kalau mau dihapus waktu rollback
    }
};
