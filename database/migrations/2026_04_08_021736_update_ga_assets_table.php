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
    Schema::table('ga_assets', function (Blueprint $table) {
        $table->dropForeign(['employee_id']); // 🔥 WAJIB
        $table->dropColumn('employee_id');    // baru bisa dihapus

        $table->integer('quantity')->default(1)->after('name');
    });
}

public function down()
{
    Schema::table('ga_assets', function (Blueprint $table) {
        $table->bigInteger('employee_id')->nullable(); // balikin kalau rollback
        $table->dropColumn('quantity');
    });
}
};
