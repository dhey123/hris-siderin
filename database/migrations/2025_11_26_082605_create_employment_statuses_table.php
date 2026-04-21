<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek: kalau tabel sudah ada → SKIP
        if (!Schema::hasTable('employment_statuses')) {
            Schema::create('employment_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('status_name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employment_statuses');
    }
};
