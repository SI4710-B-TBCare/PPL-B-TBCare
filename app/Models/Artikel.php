<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'kategori',
        'gambar',
        'isi'
    ];

    public $timestamps = false;

    protected static $logAttributes = ['nama', 'kode', 'kategori', 'gambar', 'isi'];

    public function fasilitasKesehatans()
    {
        return "You have {$eventName} artikel";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'kode'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} artikel")
            ->useLogName('artikel');
    }

    public function fasilitasKesehatan()
    {
        return $this->belongsToMany(FasilitasKesehatan::class, 'artikel_fasilitas_kesehatan')->withPivot('value_cf');
    }
}
