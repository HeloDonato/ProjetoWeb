<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{   
    protected $table = 'servidores';

    protected $fillable = [
        'nome',
        'sobrenome',
        'matricula',
        'cpf',
        'cargo',
        'funcao',
        'usuario_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    use HasFactory;
}
