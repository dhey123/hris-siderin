<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $maps = [
            'religions' => ['religion', 'agama'],
            'educations' => ['education', 'pendidikan'],
            'marital_statuses' => ['status', 'marital_status'],
            'departments' => ['department'],
            'positions' => ['position'],
            'employment_types' => ['type', 'employment_type'],
            'employment_statuses' => ['status'],
            'work_locations' => ['location'],
            'banks' => ['bank_name'],
        ];

        foreach ($maps as $table => $columns) {
            foreach ($columns as $col) {
                if (Schema::hasColumn($table, $col) && !Schema::hasColumn($table, 'name')) {
                    Schema::table($table, function (Blueprint $table) use ($col) {
                        $table->renameColumn($col, 'name');
                    });
                }
            }
        }
    }

    public function down()
    {
        // biarkan kosong supaya rollback ga merusak schema
    }
};
