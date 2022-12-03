<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planner extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_destinasi',
        'id_user',
        'tgl',
        'jumlah_orang',
        'note',
    ];

    public function destinasi(){
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
