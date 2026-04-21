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
    Schema::create('wastes', function (Blueprint $table) {
        $table->id();

        $table->string('no_dokumen');
        $table->date('tanggal');

        $table->string('jenis_limbah');
        $table->string('nama_limbah');
        $table->string('kategori');

        $table->decimal('jumlah', 10, 2);
        $table->string('satuan');

        $table->string('sumber_limbah');

        $table->string('metode_pengelolaan');
        $table->string('tujuan_pengelolaan');
        $table->string('vendor')->nullable();

        $table->string('lokasi_penyimpanan');
        $table->string('status_pengelolaan');

        $table->string('foto')->nullable();
        $table->text('keterangan')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
