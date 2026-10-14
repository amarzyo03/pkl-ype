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
        Schema::table('tb_dudi', function (Blueprint $table) {
            if (! Schema::hasColumn('tb_dudi', 'telp')) {
                $table->string('telp', 30)->nullable();
            }

            if (! Schema::hasColumn('tb_dudi', 'pic')) {
                $table->string('pic')->nullable();
            }

            if (! Schema::hasColumn('tb_dudi', 'id_jurusan')) {
                $table->foreignId('id_jurusan')->nullable()->constrained('tb_jurusan');
            }

            if (! Schema::hasColumn('tb_dudi', 'id_guru')) {
                $table->foreignId('id_guru')->nullable()->constrained('tb_guru');
            }

            if (! Schema::hasColumn('tb_dudi', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_dudi', function (Blueprint $table) {
            if (Schema::hasColumn('tb_dudi', 'id_guru')) {
                $table->dropConstrainedForeignId('id_guru');
            }

            if (Schema::hasColumn('tb_dudi', 'id_jurusan')) {
                $table->dropConstrainedForeignId('id_jurusan');
            }

            if (Schema::hasColumn('tb_dudi', 'pic')) {
                $table->dropColumn('pic');
            }

            if (Schema::hasColumn('tb_dudi', 'telp')) {
                $table->dropColumn('telp');
            }

            if (Schema::hasColumn('tb_dudi', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
