<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPengguna extends Model
{
    use HasFactory;

    protected $table = 'data_penggunas';

    protected $fillable = [
        'user_id',
        'jenis_fasilitas',
        'alamat_rumah',
        'no_telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
