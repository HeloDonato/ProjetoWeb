/@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
    <div id="cards-container" class="row" style="margin-top: 20px; min-height: 82vh;">
        <div class="card-body">
            @foreach ($relatorios as $relatorio)
                <p>{{$relatorio->nome}}<p>
            @endforeach
        </div>
    </div>

@endsection