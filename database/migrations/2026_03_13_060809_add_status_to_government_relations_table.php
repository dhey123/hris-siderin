<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('government_relations', function (Blueprint $table) {
            $table->string('status')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('government_relations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
