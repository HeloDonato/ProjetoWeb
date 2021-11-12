@extends('layouts.home')

@section('title', 'Minhas Portarias')

@section('content')
    @if(count($portaria)> 0)
        <div id="cards-container" class="row" style="margin-top: 20px;">
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
                        <tbody>
                            @foreach($portaria as $portarias)
                            
                                <tr>
                                    <td>{{$portarias->numPortaria}}</td>
                                    <td class="card-title">{{$portarias->titulo}}</td>
                                    <td class="card-date">{{$portarias->descricao}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataInicial))}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataFinal))}}</td>
                                    <td>
                                        <a href="{{ route('portaria.edit', $portarias->id) }}" class="btn btn-pesquisar edit-btn">Editar <i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $portarias->numPortaria }}">Excluir <i class="fas fa-trash-alt"></i></a>      

                                        <div class="modal fade" id="modal{{ $portarias->numPortaria  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Título da Portaria: {{ $portarias->titulo }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        O registro selecionado será excluído, deseja prosseguir?
                                                        <br>
                                                        Número da Portaria: <strong>{{  $portarias->numPortaria }}</strong> <br>
                                                        </strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('portaria.destroy', $portarias->id) }}" class="btn btn-danger">Excluir</a>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
                    
    @else
        <p>Você ainda não tem nenhuma portaria!, <a href="{{ route('portaria.create') }}">Criar Portaria</a></p>
    @endif
   
@endsection