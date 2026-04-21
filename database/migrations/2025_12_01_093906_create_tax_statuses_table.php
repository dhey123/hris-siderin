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
        Schema::create('tax_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_name'); // TK/0, TK/1, K/0, K/1, dst
            $table->string('description')->nullable(); // penjelasan singkat status pajak
            $table->integer('dependents')->default(0); // jumlah tanggungan
            $table->decimal('ptkp_amount', 15, 2); // nominal PTKP berdasarkan status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_statuses');
    }
};
