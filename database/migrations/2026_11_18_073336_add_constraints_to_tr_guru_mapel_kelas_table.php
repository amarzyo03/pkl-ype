<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasDuplicateMappings = DB::table('tr_guru_mapel_kelas')
            ->select('id_guru', 'id_mapel', 'id_kelas')
            ->groupBy('id_guru', 'id_mapel', 'id_kelas')
            ->havingRaw('COUNT(*) > 1')
            ->exists();

        if ($hasDuplicateMappings) {
            throw new RuntimeException(
                'Unique constraint tidak dapat ditambahkan: terdapat mapping guru, mapel, dan kelas yang duplikat.'
            );
        }

        foreach ([
            'id_guru' => 'tb_guru',
            'id_mapel' => 'tb_mapel',
            'id_kelas' => 'tb_kelas',
        ] as $foreignKey => $masterTable) {
            $hasOrphanedMappings = DB::table('tr_guru_mapel_kelas as mappings')
                ->leftJoin($masterTable.' as masters', 'mappings.'.$foreignKey, '=', 'masters.id')
                ->whereNull('masters.id')
                ->exists();

            if ($hasOrphanedMappings) {
                throw new RuntimeException(
                    "Foreign key {$foreignKey} tidak dapat ditambahkan: terdapat mapping tanpa data master terkait."
                );
            }
        }

        Schema::table('tr_guru_mapel_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_guru')->change();
            $table->unsignedBigInteger('id_mapel')->change();
            $table->unsignedBigInteger('id_kelas')->change();
        });

        Schema::table('tr_guru_mapel_kelas', function (Blueprint $table) {
            $table->foreign('id_guru')->references('id')->on('tb_guru')->restrictOnDelete();
            $table->foreign('id_mapel')->references('id')->on('tb_mapel')->restrictOnDelete();
            $table->foreign('id_kelas')->references('id')->on('tb_kelas')->restrictOnDelete();
            $table->unique(
                ['id_guru', 'id_mapel', 'id_kelas'],
                'tr_guru_mapel_kelas_assignment_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('tr_guru_mapel_kelas', function (Blueprint $table) {
            $table->dropForeign('tr_guru_mapel_kelas_id_guru_foreign');
            $table->dropForeign('tr_guru_mapel_kelas_id_mapel_foreign');
            $table->dropForeign('tr_guru_mapel_kelas_id_kelas_foreign');
            $table->dropUnique('tr_guru_mapel_kelas_assignment_unique');
        });

        Schema::table('tr_guru_mapel_kelas', function (Blueprint $table) {
            $table->integer('id_guru')->change();
            $table->integer('id_mapel')->change();
            $table->integer('id_kelas')->change();
        });
    }
};
