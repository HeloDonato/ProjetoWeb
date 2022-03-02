<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServidorPortaria extends Model
{
    protected $table = 'servidores_portarias';
    protected $fillable = [
        'servidor_id',
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
        return $this->belongsTo(Servidor::class, 'servidor_id');
    }

    public function portaria(){
        return $this->belongsTo(Portaria::class, 'portaria_id');
    }
}
