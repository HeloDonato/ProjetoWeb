<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model{
    use HasFactory;

    
    public function user(){
        //pertence a um usuario para fazer a forenkey
        return $this->belongsTo('App\Models\User');
    }
}
