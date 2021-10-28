@extends('layouts.main')

@section('title', 'Minhas Portarias')

@section('content')
    <div class="col-md-10 offset-md-1 dashboard-title-container">   
        <h1>Minhas Portarias</h1>
    </div>
    @if(count($portaria)> 0)
        <div id="cards-container" class="row">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered table-condensed ">
                        <thead>
                            <tr>
                                <th>Nº da Portaria</th>
                                <th>Título da Portaria</th>
                                <th>Descrição da Portaria</th>
                                <th>Data Inicial</th>
                                <th>Data Final</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        @foreach($portaria as $portarias)
                            <tbody>
                                <tr>
                                    <td>{{$portarias->numPortaria}}</td>
                                    <td class="card-title">{{$portarias->titulo}}</td>
                                    <td class="card-date">{{$portarias->descricao}}</td>
                                    <td class="card-date">{{$portarias->dataInicial}}</td>
                                    <td class="card-date">{{$portarias->dataFinal}}</td>
                                    <td>
                                        <a href="#" class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon>Editar</a>
                                        <form action="{{ route('portaria.destroy',['$portaria->id'])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon>Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
                    
    @else
        <p>Você ainda não tem nenhuma portaria!, <a href="{{ route('portaria.create') }}">Criar Portaria</a></p>
    @endif
   
@endsection