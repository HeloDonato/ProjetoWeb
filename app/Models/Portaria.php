<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
                if(isset($filter['search'])) {
                    if(!Auth::check() || auth()->user()->tipoGrupo == 'padrao'){
                        $query->where('sigilo', '=', '0')
                            ->where(function ($query) use($filter){
                                $query->where('titulo', 'LIKE', "%".$filter['search']."%")
                                ->orWhere('numPortaria', 'LIKE', "%".$filter['search']."%");
                            
                            })
                            ->get();
                            
                    }elseif(auth()->user()->tipoGrupo != 'padrao'){
                        $query->Where('titulo', 'LIKE', "%".$filter['search']."%")
                            ->orWhere('numPortaria', 'LIKE', "%".$filter['search']."%")
                            ->get();
                    }
                }else{
                    if(!Auth::check() || auth()->user()->tipoGrupo == 'padrao'){
                        $query->where('sigilo', '=', '0')
                            ->get();
                            
                    }elseif(auth()->user()->tipoGrupo != 'padrao'){
                        $query->get();
                    }
                }
            }
        })->orderBy('dataInicial', 'DESC')->paginate(10);
        return $results;
    }

    public function participantes()
    {
        return $this->hasMany(ServidorPortaria::class, 'portaria_id');
    }
    public function participantesA()
    {
        return $this->hasMany(AlunoPortaria::class, 'portaria_id');
    }

    public function minhasPortarias($idServidor)
    {   
        $results = Portaria::select('*')
            ->join('servidores_portarias', 'portarias.id', 'servidores_portarias.portaria_id')
            ->where('servidores_portarias.servidor_id', '=', $idServidor)
            ->orderBy('dataInicial', 'DESC')->paginate(10);

        return $results;
    }

    public function minhasPortariasAlunos($idAluno)
    {   
        $results = Portaria::select('*')
            ->join('alunos_portarias', 'portarias.id', 'alunos_portarias.portaria_id')
            ->where('alunos_portarias.aluno_id', '=', $idAluno)
            ->orderBy('dataInicial', 'DESC')->paginate(10);

        return $results;
    }

    public function portariaServidor($idServidor)
    {   
        if(auth()->user() == null || auth()->user()->tipoGrupo == 'padrao')
        {
            $results = Portaria::select('*')
            ->join('servidores_portarias', 'portarias.id', 'servidores_portarias.portaria_id')
            ->where('servidores_portarias.servidor_id', '=', $idServidor)
            ->where('sigilo', '=', '0')
            ->orderBy('dataInicial', 'DESC')->paginate(10);

            return $results;

        }elseif(auth()->user()->tipoGrupo != 'padrao')
        {
            $results = Portaria::select('*')
            ->join('servidores_portarias', 'portarias.id', 'servidores_portarias.portaria_id')
            ->where('servidores_portarias.servidor_id', '=', $idServidor)
            ->orderBy('dataInicial', 'DESC')->paginate(10);

            return $results;
        }   
    }

    public function portariaAluno($idALuno)
    {   
        if(auth()->user() == null || auth()->user()->tipoGrupo == 'padrao')
        {
            $results = Portaria::select('*')
            ->join('alunos_portarias', 'portarias.id', 'alunos_portarias.portaria_id')
            ->where('alunos_portarias.aluno_id', '=', $idALuno)
            ->where('sigilo', '=', '0')
            ->orderBy('dataInicial', 'DESC')->paginate(10);

            return $results;

        }elseif(auth()->user()->tipoGrupo != 'padrao')
        {
            $results = Portaria::select('*')
            ->join('alunos_portarias', 'portarias.id', 'alunos_portarias.portaria_id')
            ->where('alunos_portarias.aluno_id', '=', $idALuno)
            ->orderBy('dataInicial', 'DESC')->paginate(10);

            return $results;
        }   
    }
}