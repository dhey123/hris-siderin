<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recruitment_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruitment_applicant_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('stage'); // screening, interview, psikotes, dll
            $table->text('note')->nullable();
            $table->foreignId('user_id')->nullable(); // HR
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruitment_notes');
    }
};
