<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industrial_relations', function (Blueprint $table) {

            $table->string('status')->default('Draft')->after('tanggal');
            $table->string('file_dokumen')->nullable()->after('keterangan');

        });
    }

    public function down(): void
    {
        Schema::table('industrial_relations', function (Blueprint $table) {

            $table->dropColumn('status');
            $table->dropColumn('file_dokumen');

        });
    }
};