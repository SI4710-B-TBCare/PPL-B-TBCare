<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perkembangan_kesehatans', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('monitoring_id');

            $table->date('tanggal');

            $table->text('catatan');

            $table->timestamps();

            $table->foreign('monitoring_id')
                ->references('id')
                ->on('monitorings')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan_kesehatans');
    }
};