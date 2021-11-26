<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'funcao',
        'id_usuario'
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
    protected $guarded = [];//tudo q for enviado pelo post pode ser atualizado

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
}
