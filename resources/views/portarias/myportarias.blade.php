@extends('layouts.app')

@section('title', 'Minhas Portarias')

@section('content')
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
                                <th>Participantes</th>
                                <th>Status</th>
                                <th>Origem</th>
                                <th>Portaria</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($portarias) == 0)
                                <tr>
                                    <td colspan="9">
                                        <div class="alert border-info text-center">
                                            0 registros
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach($portarias as $portaria)
                                <tr>
                                    <td>{{$portaria->numPortaria}}</td>
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
                                    <td>
                                        <ul>
                                            @foreach ($portaria->participantes as $participante)
                                                <li>{{ $participante->servidor->nome }} {{ $participante->servidor->sobrenome }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="card-title">
                                        @if(($portaria->tipo == 1 && $portaria->permaStatus == 0) or ($portaria->tipo == 0 && $portaria->dataFinal >= $mytime = date('Y-m-d')))
                                            Ativa
                                        @elseif(($portaria->tipo == 1 && $portaria->permaStatus == 1) or ($portaria->tipo == 0 && $portaria->dataFinal < $mytime = date('Y-m-d')))
                                            Inativa 
                                        @endif
                                    </td>
                                    <td class="card-date">{{$portaria->origem}}</td>
                                    <td>
                                        <a href="{{route('portaria.view',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" target="_blank" style="margin-bottom:3px">Abrir <i class="fas fa-eye"></i></a>
                                        <a href="{{route('portaria.download',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" style="margin-bottom:3px">Baixar <i class="fas fa-download"></i></a>
                                    </td>
                                </tr>

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