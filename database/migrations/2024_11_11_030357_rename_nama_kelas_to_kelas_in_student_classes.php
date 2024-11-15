<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('student_classes', function (Blueprint $table) {
            $table->renameColumn('nama_kelas', 'kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('student_classes', function (Blueprint $table) {
            $table->renameColumn('kelas', 'nama_kelas');
        });
    }
};
