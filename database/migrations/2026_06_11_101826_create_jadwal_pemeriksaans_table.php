<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalPemeriksaansTable extends Migration
{
    public function up()
    {
        Schema::create('jadwal_pemeriksaans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('jenis_pemeriksaan');

            $table->date('tanggal_pemeriksaan');

            $table->string('lokasi');

            $table->text('catatan')->nullable();

            $table->enum('status', [
                'terjadwal',
                'selesai',
                'dibatalkan'
            ])->default('terjadwal');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_pemeriksaans');
    }
}