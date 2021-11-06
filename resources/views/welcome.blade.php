@extends('layouts.home')

@section('title', 'Portarias IFNMG')

@section('content')
    <div class="col-md-12">
        <h1 class="center">Busque uma Portaria</h1>
        <form action="/" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
        </form>
    </div>
    <div id="events-container" class="col-md-12 ">
        @if($search)
            <h2>Buscando por: {{$search}}</h2>
        @else
            <h2>Portarias</h2>
        @endif
        <div id="cards-container" class="row">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-condensed ">
                            <thead>
                                <tr >
                                    <th>Nº da Portaria</th>
                                    <th>Título da Portaria</th>
                                    <th>Descrição da Portaria</th>
                                    <th>Data Inicial</th>
                                    <th>Data Final</th>
                                    <th>Autor</th>
                                    <th>Informações</th>
                                </tr>
                            </thead>
                            @foreach ($portaria as $portarias)
                                <tbody>
                                    <tr>
                                        <td>{{$portarias->numPortaria}}</td>
                                        <td class="card-title">{{$portarias->titulo}}</td>
                                        <td class="card-date">{{$portarias->descricao}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataInicial))}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataFinal))}}</td>
                                        <td class="card-title">{{$portarias->user->name}} {{$portarias->user->sobrenome}}</td>
                                        <td class="car-title">
                                            <a href="{{ route('portaria.show', $portarias->id) }}" class="btn btn-info edit-btn"><ion-icon name="information-circle-outline"></ion-icon>Saiba Mais</a>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </div>
                    </div>
            @if(count($portaria) == 0 && $search)
                <p>Não foi possível encontrar nenhuma portaria com {{$search}}!</p>
            @elseif(count($portaria) == 0)
                <p>Não há portarias disponíveis</p>
            @endif

        </div>
    </div>
@endsection