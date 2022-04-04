<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'tipoGrupo',
        'email',
        'password',
        'nome',
        'sobrenome',
        'matricula',
        'cpf',
        'cargo',
        'funcao'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relação com a portaria
    public function portarias(){
        //tem muitas portarias
        return $this->hasMany(ServidorPortaria::class, 'usuario_id');
    }
    //relacao many to many
    public function portariaServidors($id)
    {
        $results = User::select('servidores.nome', 'servidores.sobrenome', 'servidores.matricula', 'portarias.numPortaria', 'portarias.titulo')
            ->join('servidores', 'users.id', '=', 'servidores.usuario_id')
            ->join('portarias','servidores_portarias.portaria_id', 'portarias.id')
            ->where('servidores_portarias.usuario_id', '=', $id)->get();
            
        return $results;
    }
    protected $guarded = [];//tudo q for enviado pelo post pode ser atualizado
<<<<<<< HEAD

    public function portariasTotais($id){
        $total = DB::select("SELECT COUNT(u.id) AS total FROM servidores_portarias AS sp 
                            INNER JOIN users AS u ON u.id = sp.servidor_id 
                            INNER JOIN servidores AS s ON s.usuario_id = u.id
                            INNER JOIN portarias AS p ON p.id = sp.portaria_id 
                            WHERE u.id = $id"
        );
        return $total[0]->total;
    }

    public function portariasTemporarias($id){
        $temporarias = DB::select("SELECT COUNT(u.id) AS temporarias FROM servidores_portarias AS sp 
                                    INNER JOIN users AS u ON u.id = sp.servidor_id 
                                    INNER JOIN servidores AS s ON s.usuario_id = u.id
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 0
                                    AND u.id = $id"
        );

        return $temporarias[0]->temporarias;
    }

    public function portariasPermanentes($id){
        $permanentes = DB::select("SELECT COUNT(u.id) AS permanentes FROM servidores_portarias AS sp 
                                    INNER JOIN users AS u ON u.id = sp.servidor_id 
                                    INNER JOIN servidores AS s ON s.usuario_id = u.id
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 1
                                    AND u.id = $id"
        );

        return $permanentes[0]->permanentes;
    }

    public function portariasAtivas($id, $dataAtual){
        $ativas = DB::select("SELECT COUNT(u.id) AS ativas FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.servidor_id 
                                INNER JOIN servidores AS s ON s.usuario_id = u.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE ((p.tipo = 0 AND p.dataFinal >= '$dataAtual')
                                OR (p.tipo = 1 AND p.permaStatus = 0))
                                AND u.id = $id"
        );

        return $ativas[0]->ativas;
    }

    public function portariasInativas($id, $dataAtual){
            //dd($dataAtual);
            $inativas = DB::select("SELECT COUNT(u.id) AS inativas FROM servidores_portarias AS sp 
                                    INNER JOIN users AS u ON u.id = sp.servidor_id 
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE ((p.tipo = 0 AND p.dataFinal < '$dataAtual')
                                    OR (p.tipo = 1 AND p.permaStatus = 1))
                                    AND u.id = $id"
        );

        return $inativas[0]->inativas;
    }

    public function portariasPublicas($id){
        //dd($dataAtual);
        $publicas = DB::select("SELECT COUNT(u.id) AS publicas FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.servidor_id 
                                INNER JOIN servidores AS s ON s.usuario_id = u.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.sigilo = 0
                                AND u.id = $id"
        );

        return $publicas[0]->publicas;
    }

    public function portariasSigilosas($id){
        //dd($dataAtual);
        $sigilosas = DB::select("SELECT COUNT(u.id) AS sigilosas FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.servidor_id 
                                INNER JOIN servidores AS s ON s.usuario_id = u.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.sigilo = 1
                                AND u.id = $id"
        );

        return $sigilosas[0]->sigilosas;
    }

    public function portariasCampus($id){
        //dd($dataAtual);
        $campus = DB::select("SELECT COUNT(u.id) AS campus FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.servidor_id 
                                INNER JOIN servidores AS s ON s.usuario_id = u.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.origem = 'Campus'
                                AND u.id = $id"
        );

        return $campus[0]->campus;
    }

    public function portariasReitoria($id){
        //dd($dataAtual);
        $reitoria = DB::select("SELECT COUNT(u.id) AS reitoria FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.servidor_id 
                                INNER JOIN servidores AS s ON s.usuario_id = u.id
                                INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                WHERE p.origem = 'Reitoria'
                                AND u.id = $id"
        );

        return $reitoria[0]->reitoria;
    }

    
=======
>>>>>>> 2bb7478b7ab5c36f6a4512453b5872b62206aef9
}
