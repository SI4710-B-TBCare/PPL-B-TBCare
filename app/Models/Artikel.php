<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Artikel extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'nama',
        'kode'
    ];

    public $timestamps = false;

    protected static $logAttributes = ['nama', 'kode'];

    protected static $igonoreChangedAttributes = ['updated_at'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logOnlyDirty = true;

    protected static $logName = 'artikel';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} artikel";
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsToMany(FasilitasKesehatan::class, 'artikel_fasilitas_kesehatan')->withPivot('value_cf');
    }
}
