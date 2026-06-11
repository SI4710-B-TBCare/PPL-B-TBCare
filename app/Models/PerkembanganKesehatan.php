<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerkembanganKesehatan extends Model
{
    use HasFactory;

    protected $table = 'perkembangan_kesehatans';

    protected $fillable = [
        'monitoring_id',
        'tanggal',
        'catatan'
    ];

    /**
     * Relasi ke monitoring
     */
    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }
}