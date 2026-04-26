<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitorings';

    protected $fillable = [
        'user_id',
        'tanggal',
        'hasil_lab',
        'keterangan',
        'status'
    ];

    // Relasi ke user (opsional tapi disarankan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}