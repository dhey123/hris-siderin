<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('recruitment_applicants', function (Blueprint $table) {
        $table->string('stage')->default('screening')->after('status');
    });
}

public function down(): void
{
    Schema::table('recruitment_applicants', function (Blueprint $table) {
        $table->dropColumn('stage');
    });
}

};
