@extends('layouts.main')

@section('title','Criar Portaria')

@section('content')

    <div id="event-create-container" class="col-md-6 offset-md-3">
        <h1>Cria sua Portaria</h1>
        <form action="/portarias" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Número da Portaria:</label>
                <input type="number" class="form-control" id="numPortaria" name="numPortaria" placeholder="Número da Portaria">
            </div>
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título da Portaria">
            </div>
            <div class="form-group">
                <label for="title">Descrição:</label>
                <textarea name="descricao" id="descricao" class="form-control" placeholder="Descrição da Portaria"></textarea>
            </div>
            <div class="form-group">
                <label for="date">Insira a data inicial da Portaria:</label>
                <input type="date" class="form-control" id="dataInicial" name="dataInicial">
            </div>
            <div class="form-group">
                <label for="date">Insira a data Final da Portaria:</label>
                <input type="date" class="form-control" id="dataFinal" name="dataFinal">
            </div>
            <div class="form-group">
                <label for="title">Insira o tipo da Portaria</label>
                <select name="tipo" id="tipo" class="form-control">
                    <option value="0">Temporárias</option>
                    <option value="1">Permanentes</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" value="Criar Portaria">
        </form>
    </div>


@endsection


