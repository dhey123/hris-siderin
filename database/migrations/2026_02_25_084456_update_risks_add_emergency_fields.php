<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('risks', function (Blueprint $table) {
            // Tambahan untuk tanggap darurat
            $table->text('rencana_darurat')->nullable()->after('mitigasi');
            $table->string('contact_person')->nullable()->after('rencana_darurat');
        });
    }

    public function down()
    {
        Schema::table('risks', function (Blueprint $table) {
            $table->dropColumn(['rencana_darurat', 'contact_person']);
        });
    }
};