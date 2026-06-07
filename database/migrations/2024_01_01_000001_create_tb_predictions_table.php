<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPredictionsTable extends Migration
{
    public function up()
    {
        Schema::create('tb_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 16 Fitur Gejala (0=mild, 1=moderate, 2=severe)
            // Sputum SP: 0=bloody, 1=colorless, 2=green
            $table->tinyInteger('CO')->comment('Cough / Batuk');
            $table->tinyInteger('NS')->comment('Night Sweats / Keringat Malam');
            $table->tinyInteger('BD')->comment('Breathing Difficulty / Sulit Napas');
            $table->tinyInteger('FV')->comment('Fever / Demam');
            $table->tinyInteger('CP')->comment('Chest Pain / Nyeri Dada');
            $table->tinyInteger('SP')->comment('Sputum: 0=berdarah, 1=bening, 2=hijau');
            $table->tinyInteger('IS')->comment('Immune Suppression / Penurunan Imun');
            $table->tinyInteger('LP')->comment('Loss of Pleasure / Kehilangan Minat');
            $table->tinyInteger('CH')->comment('Chills / Menggigil');
            $table->tinyInteger('LC')->comment('Lack of Concentration / Sulit Fokus');
            $table->tinyInteger('IR')->comment('Irritation / Mudah Tersinggung');
            $table->tinyInteger('LA')->comment('Loss of Appetite / Kehilangan Nafsu Makan');
            $table->tinyInteger('LE')->comment('Loss of Energy / Kehilangan Energi');
            $table->tinyInteger('LNE')->comment('Lymph Node Enlargement / Pembengkakan Kelenjar');
            $table->tinyInteger('SBP')->comment('Systolic Blood Pressure');
            $table->tinyInteger('BMI')->comment('Body Mass Index');

            // Hasil prediksi
            $table->float('risk_percentage', 5, 2)->comment('Persentase risiko TBC 0-100');
            $table->enum('risk_level', ['Rendah', 'Sedang', 'Tinggi']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_predictions');
    }
}
