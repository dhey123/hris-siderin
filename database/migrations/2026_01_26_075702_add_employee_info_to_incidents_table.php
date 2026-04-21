<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->string('nama_karyawan')->nullable()->after('employee_id');
            $table->string('department')->nullable()->after('nama_karyawan');
            $table->string('bagian')->nullable()->after('department');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['nama_karyawan', 'department', 'bagian']);
        });
    }
};
