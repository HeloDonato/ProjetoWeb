<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorPortaria extends Model
{
    protected $table = 'servidores_portarias';
    protected $fillable = [
        'usuario_id',
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

    public function id_servidor(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function id_portaria(){
        return $this->belongsTo(Portaria::class, 'portaria_id');
    }
}
