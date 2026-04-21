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
    Schema::table('ga_assets', function (Blueprint $table) {

        $table->string('asset_code')->unique()->after('id');
        $table->string('name')->after('asset_code');
        $table->string('category')->nullable()->after('name');

        $table->foreignId('employee_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete()
              ->after('category');

        $table->string('location')->nullable()->after('employee_id');

        $table->enum('condition', ['baik', 'rusak', 'maintenance'])
              ->default('baik')
              ->after('location');

        $table->date('purchase_date')->nullable()->after('condition');
        $table->decimal('price', 15, 2)->nullable()->after('purchase_date');

        $table->text('description')->nullable()->after('price');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('ga_assets', function (Blueprint $table) {
        $table->dropColumn([
            'asset_code',
            'name',
            'category',
            'employee_id',
            'location',
            'condition',
            'purchase_date',
            'price',
            'description'
        ]);
    });
}
};
