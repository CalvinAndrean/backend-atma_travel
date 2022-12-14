<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'nama',
        'total_rating',
        'deskripsi',
        'foto',
    ];

    public function rating(){
        return $this->hasMany(Destinasi::class, 'id_destinasi', 'id');
    }

    public function planner(){
        return $this->hasMany(Destinasi::class, 'id_destinasi', 'id');
    }
}
