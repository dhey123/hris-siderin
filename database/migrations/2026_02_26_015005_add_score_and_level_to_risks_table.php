<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->integer('risk_score')->nullable()->after('impact');
            $table->enum('risk_level', ['Low', 'Medium', 'High'])
                  ->nullable()
                  ->after('risk_score');
        });
    }

    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn(['risk_score', 'risk_level']);
        });
    }
};