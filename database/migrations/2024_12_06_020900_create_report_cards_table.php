<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id'); // Relasi ke tabel students
            $table->string('semester'); // Semester (contoh: Ganjil/Genap)
            $table->string('tahun_ajar'); // Tahun ajar
            $table->integer('sakit')->default(0); // Jumlah hari sakit
            $table->integer('izin')->default(0); // Jumlah hari izin
            $table->integer('alfa')->default(0); // Jumlah hari alfa
            $table->text('ekstrakurikuler')->nullable(); // Nilai atau aktivitas ekstrakurikuler

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_cards');
    }
}
