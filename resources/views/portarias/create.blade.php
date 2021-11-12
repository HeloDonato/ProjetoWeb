
@extends('layouts.admin')

@section('content')
<div class="container-fluid fundo-TCS">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/portarias2.png') }}" id="img-portarias">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Nova Portaria</h1>
                </div>
    
                {{ Form::open(['route' => 'portaria.store', 'method' => "POST",'enctype' => "multipart/form-data"]) }}
                    @csrf
                    <div class="mb-3 col-md-8">
                        <label>Número da Portaria*</label>
                        {{ Form::number('numPortaria', 'old'('numPortaria'), ['class' => 'form-control cad-servidor', 'required','placeholder' => '0','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Título da Portaria*</label>
                        {{ Form::text('titulo', 'old'('titulo'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Portaria','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Descrição da Portaria*"</label>
                        {{ Form::text('descricao', 'old'('descricao'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Descrição da Portaria','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Data Inicial da Portaria*</label>
                        {{ Form::date('dataInicial', 'old'('dataInicial'), ['class' => 'form-control cad-servidor', 'required','placeholder' => '00/00/0000', 'autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Data Final da Portaria</label>
                        {{ Form::date('dataFinal', 'old'('dataFinal'), ['class' => 'form-control cad-servidor','placeholder' => '00/00/0000','autofocus']) }}
                    </div>
                    <div class="form-group col-md-8">
                        <label for="title">Insira o tipo da Portaria</label>
                        <select name="tipo" id="tipo" class="form-control cad-servidor">
                            <option value="0">Temporárias</option>
                            <option value="1">Permanentes</option>
                        </select>
                    </div>
                    <label for="title">Escolha o servidor</label>
                    <select name="tipo" id="tipo" class="form-control cad-servidor">
                        <option selected disabled> Selecione </option>

                    </select>
                </div>
                    <div class="form-group col-md-8" style="color: #fff;">
                        <label>Arquivo da Portaria*</label><br>
                        {{ Form::file('doc')}}
                    </div>
                    <div class="mb-3 col-md-8">
                        <input type="submit" class="btn btn-enviar" value="Criar Portaria">
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection
