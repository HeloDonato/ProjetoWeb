@extends('layouts.app')

@section('title', 'Portarias')

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
                            @foreach($portarias as $portaria)
                                @if($portaria->sigilo == 0 or ($portaria->sigilo==1 and Auth::check() and Auth::user()->tipoGrupo != 'padrao'))
                                    <tr>
                                        <td>{{$portaria->numPortaria}}</td>
                                        <td>{{$portaria->titulo}}</td>
                                        <td>{{$portaria->descricao}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataInicial))}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataFinal))}}</td>
                                        <td>
                                            @foreach ($portaria->participantes as $participante)
                                                {{ $participante->servidor->nome }}
                                            @endforeach
                                        </td>
                                        <td class="card-title">
                                            @if($portaria->dataFinal < $mytime = date('Y-m-d H:i:s'))
                                                Inativa 
                                            @elseif($portaria->tipo == 0)
                                                Temporária
                                            @else
                                                Permanente
                                            @endif
                                        </td>
                                        <td class="card-date">{{$portaria->origem}}</td>
                                        <td>
                                            <a href="{{route('portaria.view',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" target="_blank" style="margin-bottom:3px">Abrir <i class="fas fa-eye"></i></a>
                                            <a href="{{route('portaria.download',$portaria->doc ?? $portaria->portaria->doc)}}" class="btn btn-pesquisar" style="margin-bottom:3px">Baixar <i class="fas fa-download"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection