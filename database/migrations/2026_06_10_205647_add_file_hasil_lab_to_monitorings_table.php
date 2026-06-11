<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileHasilLabToMonitoringsTable extends Migration
{
    public function up()
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->string('file_hasil_lab')->nullable();
        });
    }

    public function down()
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->dropColumn('file_hasil_lab');
        });
    }
}
