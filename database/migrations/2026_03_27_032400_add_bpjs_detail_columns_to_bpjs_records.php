<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bpjs_records', function (Blueprint $table) {
            $table->decimal('total_iuran', 12, 2)->nullable()->after('bpjs_ketenagakerjaan');

            $table->decimal('jkk', 12, 2)->nullable();
            $table->decimal('jht', 12, 2)->nullable();
            $table->decimal('jkm', 12, 2)->nullable();
            $table->decimal('jp', 12, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bpjs_records', function (Blueprint $table) {
            $table->dropColumn([
                'total_iuran',
                'jkk',
                'jht',
                'jkm',
                'jp'
            ]);
        });
    }
};