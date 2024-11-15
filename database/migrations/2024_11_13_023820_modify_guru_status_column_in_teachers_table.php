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
        Schema::table('teachers', function (Blueprint $table) {
            $table->enum('guru_status', ['Guru Aktif', 'Wali Kelas'])->change(); // Mengubah tipe kolom guru_status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('guru_status')->change(); // Mengembalikan ke tipe string jika di-rollback
        });
    }
};
