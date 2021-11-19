@extends('layouts.home')

@section('title', 'Portarias IFNMG')

@section('content')
    <div id="cards-container" class="row" style="min-height: 82vh;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr >
                            <th class="col-md-2">Nº da Portaria</th>
                            <th class="col-md-2">Título da Portaria</th>
                            <th class="col-md-3">Descrição da Portaria</th>
                            <th>Data Inicial</th>
                            <th>Data Final</th>
                            <th>Informações</th>
                            @if(Auth::user())
                                @if(Auth::user()->tipoGrupo != 'padrao')
                                    <th>Ações</th>
                                @endif
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($portarias as $portaria)
                        
                            <tr>
                                <td>{{$portaria->numPortaria}}</td>
                                <td class="card-title">{{$portaria->titulo}}</td>
                                <td class="card-date">{{$portaria->descricao}}</td>
                                <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataInicial))}}</td>
                                <td class="card-date">
                                    @if($portaria->dataFinal == null)
                                        Sem data
                                    @else
                                        {{date('d/m/Y',strtotime($portaria->dataFinal))}}
                                    @endif
                                </td>
                                <td class="car-title">
                                    <a href="{{route('portaria.view',$portaria->doc)}}" class="btn btn-pesquisar" target="_blank" style="margin-bottom:3px">Abrir <i class="fas fa-eye"></i></a>
                                    <a href="{{route('portaria.download',$portaria->doc)}}" class="btn btn-pesquisar" style="margin-bottom:3px">Baixar <i class="fas fa-download"></i></a>
                                    <a href="{{route('portaria.show',$portaria->id)}}" class="btn btn-pesquisar" data-toggle="modal" data-target="#modal{{ $portaria->id }}" style="margin-bottom:3px">Info <i class="fas fa-info-circle"></i></a>      

                                    <div class="modal fade" id="modal{{ $portaria->id  }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header header-modal-info">
                                                    <h5 class="modal-title"><strong>Título da Portaria: </strong>{{ $portaria->titulo }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="span-modal-info">Número da portaria:</span> {{$portaria->numPortaria}}<br><hr>
                                                    <span class="span-modal-info">Descrição da portaria:</span> {{$portaria->descricao}}<br><hr>
                                                    <span class="span-modal-info">Paricipantes dessa portaria:</span>
                                                    @foreach ($participantes as $participante)
                                                        @if($participante->portaria_id == $portaria->id)
                                                            <br> {{$participante->nome}} {{$participante->sobrenome}}
                                                        @endif
                                                    @endforeach
                                                    <br><hr>
                                                    <span class="span-modal-info">Origem da portaria:</span> {{$portaria->origem}}<br><hr>
                                                    <span class="span-modal-info">Data inicial da portaria:</span> {{$portaria->descricao}}<br><hr>
                                                    <span class="span-modal-info">Data final da portaria:</span> {{$portaria->descricao}}<br><hr>
                                                    <span class="span-modal-info">Status da portaria:</span> 
                                                    @if($portaria->dataFinal < $mytime = date('Y-m-d H:i:s'))
                                                        Inativa 
                                                    @elseif($portaria->tipo == 0)
                                                        Temporária
                                                    @else
                                                        Permanente
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if(Auth::user())
                                    @if(Auth::user()->tipoGrupo != 'padrao')
                                        <td>
                                            <a href="{{ route('portaria.edit', $portaria->id) }}" class="btn btn-secondary edit-btn" style="margin-bottom:3px">Editar <i class="fas fa-edit"></i></a>
                                            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $portaria->numPortaria }}" style="margin-bottom:3px">Excluir <i class="fas fa-trash-alt"></i></a>      

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
                                @endif
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>
@endsection