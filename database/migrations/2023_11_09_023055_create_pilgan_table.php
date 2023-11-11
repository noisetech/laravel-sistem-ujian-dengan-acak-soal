<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilgan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_soal_id');
            $table->string('huruf');
            $table->string('isi');
            $table->timestamps();

            $table->foreign('bank_soal_id')->references('id')
            ->on('bank_soal')
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
        Schema::dropIfExists('pilgan');
    }
}
