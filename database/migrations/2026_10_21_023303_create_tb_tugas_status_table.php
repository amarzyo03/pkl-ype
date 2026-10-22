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
        Schema::create('tb_tugas_status', function (Blueprint $table) {
            $table->id();
            $table->integer('id_siswa')->unsigned();
            $table->integer('id_tugas')->unsigned();
            $table->date('tanggal');
            $table->string('status')->nullable()->default(null);
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tugas_status');
    }
};
