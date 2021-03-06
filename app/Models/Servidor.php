<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{   
    protected $table = 'servidores';

    protected $fillable = [
        'nome',
        'sobrenome',
        'matricula',
        'cpf',
        'cargo',
        'funcao',
        'usuario_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function getServidor($idServidor)
    {   
        $results = Servidor::select('*')
            ->where('servidores.usuario_id', '=', $idServidor)->first();
        return $results;
    }

    public function searchServidores($filter = null)
    {
        $results = $this->where(function($query) use($filter) {
            if(count($filter) > 0) {
                if(isset($filter['search'])) {
                    $query->where('usuario_id', '!=', 1)
                        ->where(function ($query) use($filter){
                            $query->Where('nome', 'LIKE', "%".$filter['search']."%")
                                    ->orWhere('matricula', 'LIKE', "%".$filter['search']."%")
                                    ->get();
                        }); 
                }else{  
                    $query->where('usuario_id', '!=', 1)
                    ->get();
                }
            }
        })->orderBy('nome', 'ASC')->paginate(10); 

        return $results;
    }
    use HasFactory;
}
