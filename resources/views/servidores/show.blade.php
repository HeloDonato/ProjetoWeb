@extends('layouts.main')

@section('title')

@section('content')

    <div class="col-md-10 offset-md-1">
        <div class="row">
            <div id="doc-container" class="col-md-6">
            
            </div>
            <div id="info-contain1er" class="col-md-6">
                @foreach($servidor as $servidores)
                       {{$servidores->nome}}
                        <a href="{{ route('servidor.destroy', $servidores->id) }}" class="btn btn-danger">Excluir</a>
                        <a href="{{ route('servidor.edit', $servidores->id) }}" class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon>Editar</a><br><br><br>
                @endforeach
            </div>
        </div>
    </div>

@endsection