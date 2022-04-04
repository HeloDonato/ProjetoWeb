<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlunoPortaria extends Model
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

    public function aluno(){
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    public function portaria(){
        return $this->belongsTo(Portaria::class, 'portaria_id');
    }

    public function portariasTotais($id){
        $total = DB::select("SELECT COUNT(a.id) AS total FROM alunos_portarias AS ap 
                            INNER JOIN alunos AS a ON a.id = ap.aluno_id
                            INNER JOIN portarias AS p ON p.id = ap.portaria_id 
                            WHERE a.id = $id"
        );
        return $total[0]->total;
    }

    public function portariasTemporarias($id){
        $temporarias = DB::select("SELECT COUNT(a.id) AS temporarias FROM alunos_portarias AS ap 
                                    INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                    INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                    WHERE p.tipo = 0
                                    AND a.id = $id"
        );

        return $temporarias[0]->temporarias;
    }

    public function portariasPermanentes($id){
        $permanentes = DB::select("SELECT COUNT(a.id) AS permanentes FROM alunos_portarias AS ap 
                                    INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                    INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                    WHERE p.tipo = 1
                                    AND a.id = $id"
        );

        return $permanentes[0]->permanentes;
    }

    public function portariasAtivas($id, $dataAtual){
        $ativas = DB::select("SELECT COUNT(a.id) AS ativas FROM alunos_portarias AS ap 
                                INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                WHERE ((p.tipo = 0 AND p.dataFinal >= '$dataAtual')
                                OR (p.tipo = 1 AND p.permaStatus = 0))
                                AND a.id = $id"
        );

        return $ativas[0]->ativas;
    }

    public function portariasInativas($id, $dataAtual){
            //dd($dataAtual);
            $inativas = DB::select("SELECT COUNT(a.id) AS inativas FROM alunos_portarias AS ap 
                                    INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                    INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                    WHERE ((p.tipo = 0 AND p.dataFinal < '$dataAtual')
                                    OR (p.tipo = 1 AND p.permaStatus = 1))
                                    AND a.id = $id"
        );

        return $inativas[0]->inativas;
    }

    public function portariasPublicas($id){
        //dd($dataAtual);
        $publicas = DB::select("SELECT COUNT(a.id) AS publicas FROM alunos_portarias AS ap 
                                INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                WHERE p.sigilo = 0
                                AND a.id = $id"
        );

        return $publicas[0]->publicas;
    }

    public function portariasSigilosas($id){
        //dd($dataAtual);
        $sigilosas = DB::select("SELECT COUNT(a.id) AS sigilosas FROM alunos_portarias AS ap 
                                INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                WHERE p.sigilo = 1
                                AND a.id = $id"
        );

        return $sigilosas[0]->sigilosas;
    }

    public function portariasCampus($id){
        //dd($dataAtual);
        $campus = DB::select("SELECT COUNT(a.id) AS campus FROM alunos_portarias AS ap 
                                INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                WHERE p.origem = 'Campus'
                                AND a.id = $id"
        );

        return $campus[0]->campus;
    }

    public function portariasReitoria($id){
        //dd($dataAtual);
        $reitoria = DB::select("SELECT COUNT(a.id) AS reitoria FROM alunos_portarias AS ap 
                                INNER JOIN alunos AS a ON ap.aluno_id = a.id
                                INNER JOIN portarias AS p ON p.id = ap.portaria_id
                                WHERE p.origem = 'Reitoria'
                                AND a.id = $id"
        );

        return $reitoria[0]->reitoria;
    }
}
