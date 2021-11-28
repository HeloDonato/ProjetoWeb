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
        $results = User::select('users.nome', 'users.sobrenome', 'users.matricula', 'portarias.numPortaria', 'portarias.titulo')
            ->join('servidores_portarias', 'users.id', 'servidores_portarias.portaria_id')
            ->join('portarias','servidores_portarias.portaria_id', 'portarias.id')
            ->where('servidores_portarias.usuario_id', '=', $id)->get();
            
        return $results;
    }
    protected $guarded = [];//tudo q for enviado pelo post pode ser atualizado

    public function search($filter = null)
    {
        $results = $this->where(function($query) use($filter) {
            if(count($filter) > 0) {
                if(isset($filter['search']) /*and isset($filter['codigo'])*/) {
                    $query->Where('nome', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('sobrenome', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('matricula', 'LIKE', "%".$filter['search']."%")
                        ->get();
                }
            }
        })->orderBy('nome', 'DESC')->paginate(10);

        return $results;
    }

    public function portariasTotais($id){
        $total = DB::select("SELECT COUNT(u.id) AS total FROM servidores_portarias AS sp 
                            INNER JOIN users AS u ON u.id = sp.usuario_id 
                            INNER JOIN portarias AS p ON p.id = sp.portaria_id 
                            WHERE u.id = $id"
        );
        return $total[0]->total;
    }

    public function portariasTemporarias($id){
        $temporarias = DB::select("SELECT COUNT(u.id) AS temporarias FROM servidores_portarias AS sp 
                                    INNER JOIN users AS u ON u.id = sp.usuario_id 
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 0
                                    AND u.id = $id"
        );

        return $temporarias[0]->temporarias;
    }

    public function portariasPermanentes($id){
        $permanentes = DB::select("SELECT COUNT(u.id) AS permanentes FROM servidores_portarias AS sp 
                                    INNER JOIN users AS u ON u.id = sp.usuario_id 
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE p.tipo = 1
                                    AND u.id = $id"
        );

        return $permanentes[0]->permanentes;
    }

    public function portariasAtivas($id, $dataAtual){
        $ativas = DB::select("SELECT COUNT(u.id) AS ativas FROM servidores_portarias AS sp 
                                INNER JOIN users AS u ON u.id = sp.usuario_id 
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
                                    INNER JOIN users AS u ON u.id = sp.usuario_id 
                                    INNER JOIN portarias AS p ON p.id = sp.portaria_id
                                    WHERE ((p.tipo = 0 AND p.dataFinal < '$dataAtual')
                                    OR (p.tipo = 1 AND p.permaStatus = 1))
                                    AND u.id = $id"
        );

        return $inativas[0]->inativas;
    }
}
