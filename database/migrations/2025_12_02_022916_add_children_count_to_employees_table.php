<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Tambahkan kolom children_count di paling bawah (AMAN)
            if (!Schema::hasColumn('employees', 'children_count')) {
                $table->unsignedTinyInteger('children_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'children_count')) {
                $table->dropColumn('children_count');
            }
        });
    }
};
