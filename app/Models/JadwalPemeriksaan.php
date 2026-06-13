<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pemeriksaans';

    protected $fillable = [
        'user_id',
        'jenis_pemeriksaan',
        'tanggal_pemeriksaan',
        'lokasi',
        'catatan',
        'status'
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}