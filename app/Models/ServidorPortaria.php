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

    public function portariasTotais($id){
        $total = DB::select("SELECT COUNT(s.id) AS total FROM servidores_portarias AS sp 
                            INNER JOIN servidores AS s ON s.id = sp.servidor_id
                            INNER JOIN portarias AS p ON p.id = sp.portaria_id 
                            WHERE s.id = $id"
        );
        return $total[0]->total;
    }

    public function portariasTemporarias($id){
        $temporarias = DB::select("SELECT COUNT(s.id) AS temporarias FROM servidores_portarias AS sp 
                                    INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 0
                                    AND s.id = $id"
        );

        return $temporarias[0]->temporarias;
    }

    public function portariasPermanentes($id){
        $permanentes = DB::select("SELECT COUNT(s.id) AS permanentes FROM servidores_portarias AS sp 
                                    INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 1
                                    AND s.id = $id"
        );

        return $permanentes[0]->permanentes;
    }

    public function portariasAtivas($id, $dataAtual){
        $ativas = DB::select("SELECT COUNT(s.id) AS ativas FROM servidores_portarias AS sp 
                                INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE ((p.tipo = 0 AND p.dataFinal >= '$dataAtual')
                                OR (p.tipo = 1 AND p.permaStatus = 0))
                                AND s.id = $id"
        );

        return $ativas[0]->ativas;
    }

    public function portariasInativas($id, $dataAtual){
            //dd($dataAtual);
            $inativas = DB::select("SELECT COUNT(s.id) AS inativas FROM servidores_portarias AS sp 
                                    INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE ((p.tipo = 0 AND p.dataFinal < '$dataAtual')
                                    OR (p.tipo = 1 AND p.permaStatus = 1))
                                    AND s.id = $id"
        );

        return $inativas[0]->inativas;
    }

    public function portariasPublicas($id){
        //dd($dataAtual);
        $publicas = DB::select("SELECT COUNT(s.id) AS publicas FROM servidores_portarias AS sp 
                                INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.sigilo = 0
                                AND s.id = $id"
        );

        return $publicas[0]->publicas;
    }

    public function portariasSigilosas($id){
        //dd($dataAtual);
        $sigilosas = DB::select("SELECT COUNT(s.id) AS sigilosas FROM servidores_portarias AS sp 
                                INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.sigilo = 1
                                AND s.id = $id"
        );

        return $sigilosas[0]->sigilosas;
    }

    public function portariasCampus($id){
        //dd($dataAtual);
        $campus = DB::select("SELECT COUNT(s.id) AS campus FROM servidores_portarias AS sp 
                                INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.origem = 'Campus'
                                AND s.id = $id"
        );

        return $campus[0]->campus;
    }

    public function portariasReitoria($id){
        //dd($dataAtual);
        $reitoria = DB::select("SELECT COUNT(s.id) AS reitoria FROM servidores_portarias AS sp 
                                INNER JOIN servidores AS s ON sp.servidor_id = s.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.origem = 'Reitoria'
                                AND s.id = $id"
        );

        return $reitoria[0]->reitoria;
    }
}
