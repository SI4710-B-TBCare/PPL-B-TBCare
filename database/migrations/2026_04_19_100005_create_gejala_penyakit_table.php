<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGejalaPenyakitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gejala_penyakit', function (Blueprint $table) {
            $table->id();
            $table->integer('gejala_id')->unsigned();
            $table->integer('fasilitas_kesehatan_id')->unsigned();
            $table->float('value_cf')->nullable();
            
            $table->foreign('gejala_id')->references('id')->on('gejalas')->onDelete('cascade');
            $table->foreign('fasilitas_kesehatan_id')->references('id')->on('fasilitas_kesehatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gejala_penyakit');
    }
}
