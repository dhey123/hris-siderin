<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risks', function (Blueprint $table) {

            $table->dropColumn([
                'likelihood',
                'impact',
                'mitigasi',
                'rencana_darurat',
                'contact_person',
                'risk_score',
                'risk_level',
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('risks', function (Blueprint $table) {

            $table->enum('likelihood', ['Low','Medium','High'])->nullable();
            $table->enum('impact', ['Minor','Major','Critical'])->nullable();
            $table->text('mitigasi')->nullable();
            $table->text('rencana_darurat')->nullable();
            $table->string('contact_person')->nullable();
            $table->integer('risk_score')->nullable();
            $table->enum('risk_level', ['Low','Medium','High'])->nullable();

        });
    }
};