<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tb_guru')
            ->where('deleted_at', '')
            ->update(['deleted_at' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
