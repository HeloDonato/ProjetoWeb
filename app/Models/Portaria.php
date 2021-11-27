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
        'origem',
        'tipo',
        'siiglo',
        'permaStatus'
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

    //relacao ony to many
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function search($filter = null)
    {
        $results = $this->where(function($query) use($filter) {
            if(count($filter) > 0) {
                if(isset($filter['search']) /*and isset($filter['codigo'])*/) {
                    $query->Where('titulo', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('numPortaria', 'LIKE', "%".$filter['search']."%")
                        ->get();
                }
            }
        })->orderBy('dataInicial', 'DESC')->paginate(10);

        return $results;
    }

    public function participantes()
    {
        return $this->hasMany(ServidorPortaria::class, 'portaria_id');
    }

    public function minhasPortarias($idServidor)
    {
        $results = Portaria::select('*')
            ->join('servidores_portarias', 'portarias.id', 'servidores_portarias.portaria_id')
            ->where('servidores_portarias.usuario_id', '=', $idServidor)
            ->orderBy('dataInicial', 'DESC')->paginate(10);

        return $results;
    }
}