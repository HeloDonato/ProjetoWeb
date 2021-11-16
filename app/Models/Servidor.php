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
        'matricula',
        'cpf',
        'email',
        'cargo',
        'funcao'
    ];

    //relação many to many
    public function portarias(){
        return $this->belongsToMany('App\Models\Portaria','servidores_id','portarias_id');
    }
}
