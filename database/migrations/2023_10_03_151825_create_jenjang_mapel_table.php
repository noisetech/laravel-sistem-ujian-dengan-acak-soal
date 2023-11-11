<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenjangMapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenjang_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id');
            $table->foreignId('kelas_id');
            $table->foreignId('guru_id');
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')
                ->on('mapel')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('kelas_id')->references('id')
                ->on('kelas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('guru_id')->references('id')
                ->on('guru')
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
        Schema::dropIfExists('jenjang_mapel');
    }
}
