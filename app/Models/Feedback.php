<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'pesan'
    ];

    protected static $logAttributes = ['nama', 'email', 'pesan'];

    protected static $igonoreChangedAttributes = ['updated_at'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logOnlyDirty = true;

    protected static $logName = 'feedback';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} feedback";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
