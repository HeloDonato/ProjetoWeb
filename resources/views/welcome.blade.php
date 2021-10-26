@extends('layouts.main')

@section('title', 'Portarias IFNMG')

@section('content')
    <div id="search-container" class="col-md-12">
        <h1>Busque uma Portaria</h1>
        <form action="/" method="GET">
            <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
        </form>
    </div>
    <div id="events-container" class="col-md-12">
        @if($search)
            <h2>Buscando por: {{$search}}</h2>
        @else
            <h2>Portarias</h2>
            <p class="subtitle">Veja outras Portarias</p>
        @endif
        <div id="cards-container" class="now">
            @foreach($portaria as $portarias)
                <div class="card col-md-3">
                    <div class="card-body">
                        <p>{{$portarias->numPortaria}}</p>
                        <h5 class="card-title">{{$portarias->titulo}}</h5>
                        <p class="card-date">{{$portarias->descricao}}</p>
                        <p class="card-date">{{$portarias->dataInicial}}</p>
                        <p class="card-date">{{$portarias->dataFinal}}</p>
                    </div>
                </div>
            @endforeach
            @if(count($portaria) == 0 && $search)
                <p>Não foi possível encontrar nenhuma portaria com {{$search}}!</p>
            @elseif(count($portaria) == 0)
                <p>Não há portarias disponíveis</p>
            @endif

        </div>
    </div>
@endsection