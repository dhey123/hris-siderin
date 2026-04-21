<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('educations')) {
            Schema::create('educations', function (Blueprint $table) {
                $table->id();
                $table->string('education_level');
                $table->integer('order_level')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
