/@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
    <div id="cards-container" class="row" style="margin-top: 20px; min-height: 82vh;">
        <div class="card-body">
            Nome: {{$user->nome}}<br>
            Matricula: {{$user->matricula}} </br>
            Número total de portarias: {{$count}}
            <ul>    
            @foreach ($relatorios as $relatorio)
                <li> Numero da portaria: {{$relatorio->numPortaria}} </li>
                     Titulo: {{$relatorio->titulo}} </Titulo:>
            @endforeach
            </ul>
        </div>
    </div>

@endsection