<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class FasilitasKesehatan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fasilitas_kesehatan';

    public $timestamps = true;

    protected $fillable = [
        'kode',
        'nama',
        'penyebab',
    ];

    protected static $logAttributes = ['kode', 'nama', 'penyebab'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logOnlyDirty = true;

    protected static $logName = 'fasilitasKesehatan';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} fasilitas kesehatan";
    }

    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_fasilitas_kesehatan')->withPivot('id', 'value_cf');
    }
}
