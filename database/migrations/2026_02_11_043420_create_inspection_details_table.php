<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inspection_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inspection_id');
            $table->string('item');
            $table->string('standar')->nullable();
            $table->enum('hasil', ['OK', 'NG']);
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('inspection_id')
                  ->references('id')
                  ->on('inspections')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_details');
    }
};
