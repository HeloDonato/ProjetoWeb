@extends('layouts.main')

@section('title','Editando: ' . $portaria->titulo)

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Edite sua Portaria</h1>
        {{ Form::model($portaria,['route' => ['portaria.update',$portaria->id], 'method' => "POST"]) }}
            @csrf
            @method('PUT')
            {{ Form::open(['route' => 'portaria.store', 'method' => "POST"]) }}
            @csrf
            <div class="form-group">
                {{ Form::label('numPortaria', 'Número da Portaria *') }}
                {{ Form::number('numPortaria', 'old'('numPortaria'), ['class' => 'form-control', 'required','placeholder' => '0','autofocus']) }}
            </div>
            <div class="form-group">
                {{ Form::label('titulo', 'Título *') }}
                {{ Form::text('titulo', 'old'('titulo'), ['class' => 'form-control', 'required','placeholder' => 'Portaria','autofocus']) }}
            </div>
            <div class="form-group">
                {{ Form::label('descricao', 'Descrição   *') }}
                {{ Form::text('descricao', 'old'('descricao'), ['class' => 'form-control', 'required','placeholder' => 'Descrição da Portaria','autofocus']) }}
            </div>
            <div class="form-group">
                {{ Form::label('dataInicial', 'Data Inicial *') }}
                {{ Form::date('dataInicial', 'old'('dataInicial'), ['class' => 'form-control', 'required','placeholder' => '00/00/0000', 'autofocus']) }}
            </div>
            <div class="form-group">
                {{ Form::label('dataFinal', 'Data Final') }}
                {{ Form::date('dataFinal', 'old'('dataFinal'), ['class' => 'form-control','placeholder' => '00/00/0000','autofocus']) }}
            </div>
            <div class="form-group">
                <label for="title">Insira o tipo da Portaria</label>
                <select name="tipo" id="tipo" class="form-control">
                    <option value="0">Temporárias</option>
                    <option value="1">Permanentes</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" value="Criar Portaria">
        {{ Form::close() }}
    </div>


@endsection


