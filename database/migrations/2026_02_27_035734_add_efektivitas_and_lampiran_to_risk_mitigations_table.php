<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risk_mitigations', function (Blueprint $table) {

            $table->string('efektivitas')->nullable()->after('status');
            $table->string('lampiran')->nullable()->after('efektivitas');

        });
    }

    public function down(): void
    {
        Schema::table('risk_mitigations', function (Blueprint $table) {

            $table->dropColumn(['efektivitas', 'lampiran']);

        });
    }
};
