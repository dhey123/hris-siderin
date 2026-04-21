<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('recruitment_applicants', function (Blueprint $table) {
        $table->enum('application_type', ['online', 'offline'])
              ->default('online')
              ->after('job_id');

        $table->string('referral_name')->nullable()->after('application_type');
        $table->string('referral_relation')->nullable()->after('referral_name');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitment_applicants', function (Blueprint $table) {
            //
        });
    }
};
