@extends('layouts.main')

@section('title', $portaria->titulo)

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="doc-container" class="col-md-6">
            
            </div>
            <div id="info-container" class="col-md-6">
                <h3>{{$portaria->numPortaria}}</h3>
                <h1>{{$portaria->titulo}}</h1>
                <p><ion-icon name="receipt"></ion-icon> {{$portaria->descricao}}</p>
                <p><ion-icon name="calendar"></ion-icon> {{date('d/m/Y',strtotime($portaria->dataInicial))}}</p>
                <p><ion-icon name="calendar"></ion-icon> {{date('d/m/Y',strtotime($portaria->dataFinal))}}</p>
                <p><ion-icon name="person"></ion-icon> {{$portaria->user->name}} {{$portaria->user->sobrenome}}</p>

            </div>
        </div>
    </div>

@endsection