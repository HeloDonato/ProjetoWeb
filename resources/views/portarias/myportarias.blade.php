@extends('layouts.home')

@section('title', 'Minhas Portarias')

@section('content')
    @if(count($portarias)> 0)
        <div id="cards-container" class="row" style="min-height:82vh">
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
                                @if(Auth::user()->tipoGrupo != 'padrao')
                                    <th>Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portarias as $portaria)
                            
                                <tr>
                                    <td>{{$portaria->numPortaria}}</td>
                                    <td class="card-title">{{$portaria->titulo}}</td>
                                    <td class="card-date">{{$portaria->descricao}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataInicial))}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataFinal))}}</td>
                                    @if(Auth::user()->tipoGrupo != 'padrao')
                                        <td>
                                            <a href="{{ route('portaria.edit', $portaria->id) }}" class="btn btn-pesquisar edit-btn">Editar <i class="fas fa-edit"></i></a>
                                            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $portaria->numPortaria }}">Excluir <i class="fas fa-trash-alt"></i></a>      

                                            <div class="modal fade" id="modal{{ $portaria->numPortaria  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Título da Portaria: {{ $portaria->titulo }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            O registro selecionado será excluído, deseja prosseguir?
                                                            <br>
                                                            Número da Portaria: <strong>{{  $portaria->numPortaria }}</strong> <br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('portaria.destroy', $portaria->id) }}" class="btn btn-danger">Excluir</a>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection