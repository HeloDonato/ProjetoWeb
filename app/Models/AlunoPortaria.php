<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServidorPortaria extends Model
{
    protected $table = 'alunos_portarias';
    protected $fillable = [
        'aluno_id',
        'portaria_id',
    ];

    use HasFactory;
    //para tratar os campos multiselecionados
    protected $casts = [
        'items' => 'array'
    ];

    //data
    protected $dates = [
        'data'
    ];

    protected $guarded = [];//tudo q for enviado pelo post pode ser atualizado

    public function servidor(){
        return $this->belongsTo(User::class, 'aluno_id');
    }

    public function portaria(){
        return $this->belongsTo(Portaria::class, 'portaria_id');
    }
}
