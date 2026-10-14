<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('tb_siswa', 'kelas')) {
            return;
        }

        $kelasByName = [];
        foreach (DB::table('tb_kelas')->get(['id', 'nama']) as $kelas) {
            $kelasByName[mb_strtolower(trim($kelas->nama))] ??= $kelas->id;
        }

        $students = DB::table('tb_siswa')->get(['id', 'kelas']);
        $studentClassIds = [];
        foreach ($students as $student) {
            $className = mb_strtolower(trim($student->kelas));
            if (! isset($kelasByName[$className])) {
                throw new RuntimeException(
                    'Data kelas siswa tidak dapat dimigrasikan karena ada nama kelas yang tidak ditemukan di tb_kelas.'
                );
            }

            $studentClassIds[$student->id] = $kelasByName[$className];
        }

        if (! Schema::hasColumn('tb_siswa', 'id_kelas')) {
            Schema::table('tb_siswa', function (Blueprint $table) {
                $table->unsignedBigInteger('id_kelas')->nullable();
            });
        }

        foreach ($studentClassIds as $studentId => $classId) {
            DB::table('tb_siswa')
                ->where('id', $studentId)
                ->update(['id_kelas' => $classId]);
        }

        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });

        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kelas')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('tb_siswa', 'id_kelas') || Schema::hasColumn('tb_siswa', 'kelas')) {
            return;
        }

        $classNamesById = DB::table('tb_kelas')->pluck('nama', 'id');
        $students = DB::table('tb_siswa')->get(['id', 'id_kelas']);
        $studentClassNames = [];
        foreach ($students as $student) {
            if (! isset($classNamesById[$student->id_kelas])) {
                throw new RuntimeException(
                    'Data kelas siswa tidak dapat dikembalikan karena ada ID kelas yang tidak ditemukan di tb_kelas.'
                );
            }

            $studentClassNames[$student->id] = $classNamesById[$student->id_kelas];
        }

        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->string('kelas')->nullable();
        });

        foreach ($studentClassNames as $studentId => $className) {
            DB::table('tb_siswa')
                ->where('id', $studentId)
                ->update(['kelas' => $className]);
        }

        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->dropColumn('id_kelas');
        });

        Schema::table('tb_siswa', function (Blueprint $table) {
            $table->string('kelas')->nullable(false)->change();
        });
    }
};
