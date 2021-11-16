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
                            <th class="col-info">Informações</th>
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
                                    <a href="{{route('portaria.view',$portaria->doc)}}" class="btn btn-pesquisar" target="_blank">Abrir <i class="fas fa-eye"></i></a>
                                    <a href="{{route('portaria.download',$portaria->doc)}}" class="btn btn-pesquisar">Baixar <i class="fas fa-download"></i></a>
                                    <a href="" class="btn btn-pesquisar" data-toggle="modal" data-target="#modal{{ $portaria->numPortaria }}">Info <i class="fas fa-info-circle"></i></a>      

                                    <div class="modal fade" id="modal{{ $portaria->numPortaria  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><strong>Título da Portaria: </strong>{{ $portaria->titulo }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>Número da portaria:</strong> {{$portaria->numPortaria}}<br><hr>
                                                    <strong>Descrição da portaria:</strong> {{$portaria->descricao}}<br><hr>
                                                    <strong>Paricipantes dessa portaria:</strong><br><hr>
                                                    <strong>Origem da portaria:</strong> {{$portaria->origem}}<br><hr>
                                                    <strong>Data inicial da portaria:</strong> {{$portaria->descricao}}<br><hr>
                                                    <strong>Data final da portaria:</strong> {{$portaria->descricao}}<br><hr>
                                                    <strong>Status da portaria:</strong> 
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
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="div-paginacao">
                {{$portarias->links()}}
            </div>
            <br>
        </div>
    </div>
@endsection