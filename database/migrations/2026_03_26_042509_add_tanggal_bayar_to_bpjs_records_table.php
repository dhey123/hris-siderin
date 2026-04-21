<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bpjs_records', function (Blueprint $table) {
            $table->date('tanggal_bayar_kesehatan')->nullable()->after('bpjs_kesehatan');
            $table->date('tanggal_bayar_ketenagakerjaan')->nullable()->after('bpjs_ketenagakerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('bpjs_records', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_bayar_kesehatan',
                'tanggal_bayar_ketenagakerjaan'
            ]);
        });
    }
};
