<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function servidor(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function portaria(){
        return $this->belongsTo(Portaria::class, 'portaria_id');
    }

    public function search($filter = null)
    {
        $results = $this->where(function($query) use($filter) {
            if(count($filter) > 0) {
                if(isset($filter['search']) /*and isset($filter['codigo'])*/) {
                    $search = $filter['search'];
                   /* $query->join('portarias', 'servidores_portarias.portaria_id', 'portarias.id')
                        ->join('users', 'servidores_portarias.usuario_id', 'users.id')
                        ->Where('portarias.id', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('portarias.numPortaria', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('users.nome', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('users.sobrenome', 'LIKE', "%".$filter['search']."%")
                        ->get();
                    $results = DB::table('servidores_portarias')
                        ->join('portarias', 'servidores_portarias.portaria_id', 'portarias.id')
                        ->join('users', 'servidores_portarias.usuario_id', 'users.id')
                        ->select('portarias.*', 'users.nome')
                        ->orWhere('portarias.numPortaria', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('users.nome', 'LIKE', "%".$filter['search']."%")
                        ->orWhere('users.sobrenome', 'LIKE', "%".$filter['search']."%")
                        ->get();

                    $results = DB::select("select * from servidores_portarias as sp inner join portarias as p on sp.portaria_id = p.id
                        inner join users as u on sp.usuario_id = u.id where p.titulo like '%$search%' or p.numPortaria like '%$search%' 
                        or u.nome like '%$search%' or u.sobrenome like '%$search%' group by p.id");

                    dd($results);*/
                }
            }
        })->orderBy('dataInicial', 'DESC')->paginate(10);

        return $results;
    }
}
