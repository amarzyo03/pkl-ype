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
        if (! Schema::hasColumn('tb_guru', 'id_jurusan')) {
            Schema::table('tb_guru', function (Blueprint $table): void {
                $table->unsignedInteger('id_jurusan')->nullable()->after('nama');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $jurusanColumn = collect(Schema::getColumns('tb_guru'))
            ->firstWhere('name', 'id_jurusan');

        if ($jurusanColumn !== null && $jurusanColumn['nullable']) {
            Schema::table('tb_guru', function (Blueprint $table): void {
                $table->dropColumn('id_jurusan');
            });
        }
    }
};
