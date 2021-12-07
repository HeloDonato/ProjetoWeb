@extends('layouts.app')

@section('title', 'Portarias')

@section('content')
        <div id="cards-container" class="row" style="min-height:82vh">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed ">
                        <thead>
                            <tr>
                                <th>Nº da Portaria</th>
                                <th>Título da Portaria</th>
                                <th>Descrição da Portaria</th>
                                <th>Data Inicial</th>
                                <th>Data Final</th>
                                <th class="col-md-3">Informações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($portarias) == 0)
                                <tr>
                                    <td colspan="6">
                                        <div class="alert border-info text-center">
                                            0 registros
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach($portarias as $portaria)
                                @if($portaria->sigilo == 0 or ($portaria->sigilo==1 and Auth::check() and Auth::user()->tipoGrupo != 'padrao'))
                                    <tr>
                                        <td>
                                            {{$portaria->numPortaria}}
                                            @if($portaria->sigilo==1)
                                                <i class="fas fa-shield-alt" style="color:red;"></i>
                                            @endif
                                        </td>
                                        <td>{{$portaria->titulo}}</td>
                                        <td>{{$portaria->descricao}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataInicial))}}</td>
                                        <td class="card-date">
                                            @if($portaria->dataFinal == null)
                                                Sem data
                                            @else
                                                {{date('d/m/Y',strtotime($portaria->dataFinal))}}
                                            @endif
                                        </td>
                                        <td class="col-md-3">
                                            <a href="{{route('portaria.view',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" target="_blank" style="margin-bottom:3px">Abrir <i class="fas fa-eye"></i></a>
                                            <a href="{{route('portaria.download',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" style="margin-bottom:3px">Baixar <i class="fas fa-download"></i></a>
                                            <a href="" class="btn btn-pesquisar" data-toggle="modal" data-target="#modal{{ $portaria->id ?? $portaria->portaria_id }}" style="margin-bottom:3px">Info <i class="fas fa-info-circle"></i></a>      

                                            <div class="modal fade" id="modal{{ $portaria->id ?? $portaria->portaria_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header header-modal-info">
                                                            <h5 class="modal-title"><strong>Título da Portaria: </strong>{{ $portaria->titulo}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span class="span-modal-info">Número da portaria:</span> {{$portaria->numPortaria}}<br><hr>
                                                            <span class="span-modal-info">Descrição da portaria:</span> {{$portaria->descricao}}<br><hr>
                                                            <span class="span-modal-info">Paricipantes dessa portaria:</span>
                                                                <ul>
                                                                    @foreach ($portaria->participantes as $participante)
                                                                        <li>{{ $participante->servidor->nome }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            <hr>
                                                            <span class="span-modal-info">Origem da portaria:</span> {{$portaria->origem}}<br><hr>
                                                            <span class="span-modal-info">Data inicial da portaria:</span> {{date('d/m/Y',strtotime($portaria->dataInicial))}}<br><hr>
                                                            <span class="span-modal-info">Data final da portaria:</span> 
                                                            @if($portaria->dataFinal == null)
                                                                Sem data
                                                            @else
                                                                {{date('d/m/Y',strtotime($portaria->dataFinal))}}
                                                            @endif
                                                            <br><hr>
                                                            <span class="span-modal-info">Tipo da portaria:</span> 
                                                                @if($portaria->tipo == 0)
                                                                    Temporária
                                                                @else
                                                                    Permanente
                                                                @endif    
                                                            <br><hr>
                                                            <span class="span-modal-info">Status da portaria:</span> 
                                                            @if(($portaria->tipo == 1 && $portaria->permaStatus == 0) or ($portaria->tipo == 0 && $portaria->dataFinal >= $mytime = date('Y-m-d')))
                                                                Ativa
                                                            @elseif(($portaria->tipo == 1 && $portaria->permaStatus == 1) or ($portaria->tipo == 0 && $portaria->dataFinal < $mytime = date('Y-m-d')))
                                                                Inativa 
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="div-paginacao">
                    {{ $portarias->links() }}
                </div>
            </div>
        </div>
@endsection