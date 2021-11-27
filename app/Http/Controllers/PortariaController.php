<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Portaria;
use App\Models\ServidorPortaria;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\New_;

class PortariaController extends Controller
{
    public function index()
    {
        $portarias = Portaria::orderBy('created_at','desc')->paginate(10);//ordenando a ultima criada 

        return view('welcome',['portarias'=> $portarias,'search']);
    }

    public  function search(Request $request, Portaria $portaria){
        $portaria = new Portaria();
        $search = $request->except('_token');

        $portarias = $portaria->search($request->except('_token'));

        //dd($portarias);
        return view('welcome', [
            'portarias' => $portarias,
            'filters' => $search,
        ]);
    }

    public function create(){
        $servidores = DB::table('users')->where('users.id', 'not like', '1')->get();
        return view('portarias.create')->with('servidores', $servidores);
    }

    public function store(Request $request){
        //dd($request->all());
        $portaria = new Portaria;
        //dd($request->id_servidor);
        try{
            $portaria->numPortaria = $request->numPortaria;
            $portaria->titulo = $request->titulo;
            $portaria->descricao = $request->descricao;
            $portaria->dataInicial = $request->dataInicial;
            $portaria->dataFinal = $request->dataFinal;
            $portaria->tipo = $request->tipo;
            $portaria->origem = $request->origem;
            $portaria->sigilo = $request->sigilo;
            if($portaria->tipo == 1)
                $portaria->permaStatus = false;
            elseif($portaria->tipo == 0)
                $portaria->permaStatus = null;

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
            
            //upload do doc

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
            $portaria->save();

            try{
                $ultima_portaria = Portaria::max('id');
                $id_portaria = $ultima_portaria;
                $servidores = User::all();
                $id_servidores = $request->id_servidor;
                if(!empty($id_servidores)){
                    foreach($servidores as $servidor){
                        foreach($id_servidores as $id_servidor){
                            if($id_servidor == $servidor->id){
                                $portaria_servidor = new ServidorPortaria;
                                $portaria_servidor->portaria_id= $id_portaria;
                                $portaria_servidor->usuario_id = $id_servidor;
                                $portaria_servidor->save();
                            }
                        }
                    }
                }
            }catch(QueryException $e){
                return redirect()->back()->with('msgE','Portaria criada com sucesso, mas não foi possível identificar os servidores!');
            }
        return redirect('/')->with('msg','Portaria criada com sucesso!');
        }catch(QueryException $e){
            return redirect()->back()->with('msgE','Erro ao criar a portaria!');
        }
    }

    public function myportarias(){
        $user = auth()->user();
        $userId = $user->id;

        $portaria = new Portaria();
        $portarias = $portaria->minhasPortarias($userId);

        
        //dd($portarias);
        return view('portarias.myportarias')->with('portarias', $portarias);
    }

    public function portariasServidor($id){
        $user = User::find($id);

        $portaria = new Portaria();
        $portarias = $portaria->minhasPortarias($user->id);

        
        //dd($portarias);
        return view('portarias.servidoresPortarias')->with('portarias', $portarias)->with('servidor', $user);
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
        $participantes = DB::select(DB::raw("select portaria_id, usuario_id, nome, sobrenome FROM servidores_portarias as s 
        INNER JOIN users as u ON s.usuario_id = u.id where portaria_id = $id;"));
        
        $servidores = DB::table('users')->where('users.id', 'not like', '1')->get();
        //dd($portaria->id);

        return view('portarias.edit',['portaria' => $portaria, 'participantes'=>$participantes, 'servidores'=>$servidores]);

    }
    
    public function update(Request $request){
        try{
            Portaria::findOrFail($request->id)->update($request->all());

            try{
                $portaria = Portaria::findOrFail($request->id);
                $id_portaria = $portaria->id;
                $servidores = User::all();
                $id_servidores = $request->id_servidor;

                if($request->id_servidor != null){

                    DB::table('servidores_portarias')->where('portaria_id', '=', $id_portaria)->delete();

                    foreach($servidores as $servidor){
                        foreach($id_servidores as $id_servidor){
                            if($id_servidor == $servidor->id){
                                $portaria_servidor = new ServidorPortaria;
                                $portaria_servidor->portaria_id = $id_portaria;
                                $portaria_servidor->usuario_id  = $id_servidor;
                                $portaria_servidor->save();
                            }
                        }
                    }
                }
            }catch(QueryException $e){
                    return redirect()->back()->with('msgE','Portaria criada com sucesso, mas não foi possível identificar os servidores!');
            }

            return redirect('/')->with('msg','Portaria editada com sucesso!');
        }catch(QueryException $e){
            return redirect('/')->with('msgE','Erro ao editar portaria!');
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



