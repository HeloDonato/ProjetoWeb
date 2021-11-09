<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;

    
    protected $table = 'servidores';
    
    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'cargo',
    ];

    //relação many to many
    public function portarias(){
        return $this->belongsToMany('App\Models\Portaria');
    }
}
