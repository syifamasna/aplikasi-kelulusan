<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePpdbGradesTableForTotals extends Migration
{
    public function up()
    {
        Schema::table('ppdb_grades', function (Blueprint $table) {
            // Tambahkan kolom total_score dan total_average
            $table->integer('total_score')->nullable()->after('report_card_ids');
            $table->decimal('total_average', 5, 2)->nullable()->after('total_score');

            // Hapus kolom average_subjects dan final_average
            $table->dropColumn(['average_subjects', 'final_average']);
        });
    }

    public function down()
    {
        Schema::table('ppdb_grades', function (Blueprint $table) {
            // Rollback: kembalikan average_subjects dan final_average
            $table->json('average_subjects')->nullable();
            $table->decimal('final_average', 5, 2)->nullable();

            // Hapus kolom total_score dan total_average
            $table->dropColumn(['total_score', 'total_average']);
        });
    }
}
