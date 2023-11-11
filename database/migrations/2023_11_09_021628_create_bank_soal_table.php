<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->id();
            $table->string('no_urut');
            $table->longText('soal');
            $table->string('jawaban_benar');
            $table->foreignId('jenjang_mapel_id');
            $table->integer('score')->nullable();
            $table->timestamps();

            $table->foreign('jenjang_mapel_id')->references('id')
                ->on('jenjang_mapel')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_soal');
    }
}
