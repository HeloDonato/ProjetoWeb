@extends('layouts.home')

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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portarias as $portaria)
                            
                                <tr>
                                    <td>{{$portaria->numPortaria}}</td>
                                    <td>{{$portaria->titulo}}</td>
                                    <td>{{$portaria->descricao}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataInicial))}}</td>
                                    <td class="card-date">{{date('d/m/Y',strtotime($portaria->dataFinal))}}</td>
                                    <td>
                                        @foreach($participantes as $participante)
                                            @if($participante->portaria_id == $portaria->id)
                                                {{$participante->nome}} {{$participante->sobrenome}} /
                                            @endif
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
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection