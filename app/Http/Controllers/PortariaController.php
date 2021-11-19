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

class PortariaController extends Controller
{
    public function index()
    {
        $search = request('search');//buscar
        if($search){
            $portarias = Portaria::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $portarias = Portaria::orderBy('created_at','desc')->paginate(10);//ordenando a ultima criada 
        }
        return view('welcome',['portarias'=> $portarias,'search' => $search]);
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
       /* $portarias = User::join('servidores_portarias', 'servidores_portarias,usuario_id', '=', 'users.id')
        ->join('portarias', 'servidores_portarias.portarias_id', '=', 'portarias.id')
        ->where('$userId', '=', 'servidores_portarias.usuario_id')->get();
        return view('portarias.myportarias')->with('portarias', $portarias);
        */
        $portarias = DB::select(DB::raw("Select * from users 
        inner join servidores_portarias on (servidores_portarias.usuario_id = users.id) 
        inner join portarias on (servidores_portarias.portaria_id = portarias.id)
        where $userId = servidores_portarias.usuario_id"));
        return view('portarias.myportarias')->with('portarias', $portarias);


        $search = request('search');//buscar
        if($search){
            $portarias = Portaria::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();  
        }else{
            $portarias = Portaria::orderBy('created_at','desc')->get();//ordenando a ultima criada 
        }
        return view('portarias.myportarias',['portarias' => $portarias, 'search' => $search]);
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



