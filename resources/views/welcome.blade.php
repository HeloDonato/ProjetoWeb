@extends('layouts.home')

@section('title', 'Portarias IFNMG')

@section('content')
    <div id="cards-container" class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr >
                            <th>Nº da Portaria</th>
                            <th>Título da Portaria</th>
                            <th>Descrição da Portaria</th>
                            <th>Data Inicial</th>
                            <th>Data Final</th>
                            <th>Origem</th> 
                            <th>Status</th>
                            <th>Informações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($portaria as $portarias)
                        
                            <tr>
                                <td>{{$portarias->numPortaria}}</td>
                                <td class="card-title">{{$portarias->titulo}}</td>
                                <td class="card-date">{{$portarias->descricao}}</td>
                                <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataInicial))}}</td>
                                <td class="card-date">
                                    @if($portarias->dataFinal == null)
                                        Sem data
                                    @else
                                        {{date('d/m/Y',strtotime($portarias->dataFinal))}}
                                    @endif
                                </td>
                                <td class="card-title">{{$portarias->origem}}</td>
                                <td class="card-title">
                                
                                    @if($portarias->dataFinal < $mytime = date('Y-m-d H:i:s'))
                                        Inativa 
                                    @elseif($portarias->tipo == 0)
                                        Temporária
                                    @else
                                        Permanente
                                    @endif
                                </td>
                                <td class="car-title">
                                    <a href="{{route('portaria.view',$portarias->doc)}}" class="btn btn-pesquisar" target="_blank">Visualizar <i class="fas fa-eye"></i></a>
                                    <a href="{{route('portaria.download',$portarias->doc)}}" class="btn btn-pesquisar">Baixar <i class="fas fa-download"></i></a>
                                </td>
                            </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection