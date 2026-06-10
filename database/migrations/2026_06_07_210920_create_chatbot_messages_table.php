<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatbotMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('chatbot_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('prediction_id')->nullable();
            $table->string('role', 10); // nilai: 'user' atau 'model'
            $table->text('content');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('prediction_id')
                  ->references('id')
                  ->on('tb_predictions')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_messages');
    }
}
