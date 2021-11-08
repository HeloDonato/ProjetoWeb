<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PortariaController extends Controller
{
    public function index()
    {
        $search = request('search');//buscar
        if($search){
            $portaria = Portaria::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $portaria = Portaria::orderBy('created_at','desc')->get();//ordenando a ultima criada 

        }
        return view('welcome',['portaria'=> $portaria,'search' => $search]);
    }

    public function create(){
        return view('portarias.create');
    }

    public function show($id){
        $portaria = Portaria::findOrfail($id);
        
        //$portariaOwner = User::where('id',$portaria->user_id)->first()->toArray();


        return view('portarias.show',['portaria' => $portaria]);
    }

    public function store(Request $request){
        $portaria = new Portaria;

        try{
            $portaria->numPortaria = $request->numPortaria;
            $portaria->titulo = $request->titulo;
            $portaria->descricao = $request->descricao;
            $portaria->dataInicial = $request->dataInicial;
            $portaria->dataFinal = $request->dataFinal;
            $portaria->tipo = $request->tipo;

            //uploard do doc
            if($request->hasFile('doc') && $request->file('doc')->isValid()){
                
                $requestdoc = $request->doc;

                $extension = $requestdoc->extension();

                $docName = md5($requestdoc->getClientOriginalName() . strtotime("now")) . "." . $extension;

                $requestdoc->move(storage_path('portarias'), $docName);

                $portaria->doc = $docName;

            }

            //relação ony to many
            $user = auth()->user();
            $portaria->user_id = $user->id;

            $portaria->save();
            return redirect('/')->with('msg','Portaria criada com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao criar a portaria!');
        }
    }
    public function myportarias(){
        $user = auth()->user();
        $portaria = $user->portarias;

        return view('portarias.myportarias',['portaria' => $portaria]);
    }

    public function destroy($id){
        $portaria = Portaria::find($id);
        try{
            $portaria->delete();
            return redirect()->back()->with('msg','Portaria excluída com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao excluir!');
        }
    }
    
    public function edit($id){

        $portaria = Portaria::findOrFail($id);
        //dd($portaria->id);

        return view('portarias.edit',['portaria' => $portaria]);

    }
    
    public function update(Request $request){
        try{
            Portaria::findOrFail($request->id)->update($request->all());
            return redirect('/portaria/myportarias')->with('msg','Portaria editada com sucesso!');
        }catch(QueryException $e){
            return redirect('/portaria/myportarias')->with('msgE','Erro ao editar portaria!');
        }

    }

    public function download(Request $request,$doc){

        return response()->download(storage_path('portarias/'.$doc));    

    }

    public function view($doc){

        $docFile = "portarias/$doc";

        return response()->file(storage_path($docFile));


    }
}



