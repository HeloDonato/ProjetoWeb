<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portaria extends Model
{

    protected $table = 'portarias';
    protected $fillable = [
        'numPortaria',
        'titulo',
        'descricao',
        'dataInicial',
        'dataFinal',
        'tipo'
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

    //relacao com o usuario dono da portaria
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}