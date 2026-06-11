<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Monitoring extends Model
{
    use HasFactory;

    protected $table = 'monitorings';

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'hasil_lab',
        'keterangan',
        'status',
        'file_hasil_lab'

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perkembangan()
    {
        return $this->hasMany(PerkembanganKesehatan::class);
    }

}