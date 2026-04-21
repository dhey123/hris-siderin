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
    Schema::create('ga_requests', function (Blueprint $table) {
        $table->id();

        $table->string('request_code')->unique();

        $table->string('item_name');
        $table->integer('qty');

        $table->text('description')->nullable();

        $table->enum('status', ['pending', 'approved', 'rejected', 'done'])
              ->default('pending');

        $table->date('request_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ga_requests');
    }
};
