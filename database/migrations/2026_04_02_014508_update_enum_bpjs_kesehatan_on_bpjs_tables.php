<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // bpjs_records
        DB::statement("
            ALTER TABLE bpjs_records 
            MODIFY bpjs_kesehatan ENUM('paid','unpaid','mandiri') NULL
        ");

        // bpjs_histories
        DB::statement("
            ALTER TABLE bpjs_histories 
            MODIFY bpjs_kesehatan ENUM('paid','unpaid','mandiri') NOT NULL
        ");
    }

    public function down(): void
    {
        // ⚠️ rollback: hapus 'mandiri'
        DB::statement("
            ALTER TABLE bpjs_records 
            MODIFY bpjs_kesehatan ENUM('paid','unpaid') NULL
        ");

        DB::statement("
            ALTER TABLE bpjs_histories 
            MODIFY bpjs_kesehatan ENUM('paid','unpaid') NOT NULL
        ");
    }
};