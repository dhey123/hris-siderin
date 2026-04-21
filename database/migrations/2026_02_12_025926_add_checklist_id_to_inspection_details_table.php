<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inspection_details', function (Blueprint $table) {
            $table->unsignedBigInteger('checklist_id')
                  ->nullable()
                  ->after('inspection_id');

            $table->foreign('checklist_id')
                  ->references('id')
                  ->on('inspection_checklists')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inspection_details', function (Blueprint $table) {
            $table->dropForeign(['checklist_id']);
            $table->dropColumn('checklist_id');
        });
    }
};
