<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_user',
        'id_destinasi',
        'komentar',
        'rating',
    ];

    public function destinasi(){
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}