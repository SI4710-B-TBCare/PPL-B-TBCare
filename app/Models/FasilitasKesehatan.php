<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FasilitasKesehatan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fasilitas_kesehatan';

    protected $fillable = [
        'kode',
        'nama',
        'penyebab'
    ];

    public $timestamps = false;

    protected static $logAttributes = ['nama', 'kode'];

    protected static $igonoreChangedAttributes = ['updated_at'];

    protected static $recordEvents = ['created', 'updated', 'deleted'];

    protected static $logOnlyDirty = true;

    protected static $logName = 'fasilitasKesehatan';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "You have {$eventName} fasilitas kesehatan";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'kode'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} fasilitas kesehatan")
            ->useLogName('fasilitasKesehatan');
    }

    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_fasilitas_kesehatan')->withPivot('value_cf');
    }
}
