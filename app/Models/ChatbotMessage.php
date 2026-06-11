<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    protected $table = 'chatbot_messages';

    protected $fillable = [
        'user_id',
        'prediction_id',
        'role',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prediction()
    {
        return $this->belongsTo(TbPrediction::class, 'prediction_id');
    }
}
