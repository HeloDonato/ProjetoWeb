<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;
use App\Models\Servidor;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Date;
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
            $portaria->origem = $request->origem;

            $registros = Portaria::all();

            //Retornando mensagem de erro caso o número da portaria já exista no banco     
            foreach($registros as $registro){
                if($registro->numPortaria == $portaria->numPortaria){
                    return redirect()
                            ->back()    
                            ->withInput()
                            ->with('msgE','Não foi possível registrar a portaria! Número da portaria já registrado!');
                }
            }

            //Retornando mensagem de erro caso a data fianl seja nula para portarias temporárias
            if($portaria->tipo == '0'){
                if($portaria->dataFinal == null){
                    return redirect()
                            ->back()
                            ->withInput()
                            ->with('msgE','Não foi possível registrar a portaria! Data final obrigatória para portarias temporárias!');
                }
            }
          
            //uploard do doc

            if($request->hasFile('doc')){
                if($request->file('doc')->isValid()){
                    $requestdoc = $request->doc;

                    $extension = $requestdoc->extension();
    
                    $docName = md5($requestdoc->getClientOriginalName() . strtotime("now")) . "." . $extension;
    
                    $requestdoc->move(storage_path('portarias'), $docName);
    
                    $portaria->doc = $docName;
                }else{
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('msgE','Não foi possível registrar a portaria! Problemas com o processamento do arquivo!');
                }
            }else{
                return redirect()
                        ->back()
                        ->withInput()
                        ->with('msgE','Erro ao cadastarar portaria! Selecione um arquivo para ser enviado!');
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

        $search = request('search');//buscar
        if($search){
            $portaria = Portaria::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $portaria = Portaria::orderBy('created_at','desc')->get();//ordenando a ultima criada 
        }
        return view('portarias.myportarias',['portaria' => $portaria, 'search' => $search]);
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



