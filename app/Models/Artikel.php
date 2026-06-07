<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function fasilitasKesehatans()
    {
        return $this->belongsToMany(FasilitasKesehatan::class, 'artikel_fasilitas_kesehatan')->withPivot('id', 'value_cf');
    }
}
