<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelFasilitasKesehatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_fasilitas_kesehatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artikel_id');
            $table->unsignedBigInteger('fasilitas_kesehatan_id');
            $table->decimal('value_cf', 5, 2)->nullable();
            
            $table->foreign('artikel_id')->references('id')->on('artikels')->onDelete('cascade');
            $table->foreign('fasilitas_kesehatan_id')->references('id')->on('fasilitas_kesehatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_fasilitas_kesehatan');
    }
}
