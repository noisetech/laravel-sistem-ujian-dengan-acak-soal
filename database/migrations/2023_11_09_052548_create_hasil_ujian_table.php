<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->unsignedBigInteger('jenjang_mapel_id');
            $table->integer('hasil')->nullable();
            $table->timestamps();

            $table->foreign('users_id')->references('id')
                ->on('jenjang_mapel')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('hasil_ujian');
    }
}
