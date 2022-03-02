
@extends('layouts.admin')

@section('content')
<div class="container-fluid fundo-TCS">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/servidores.png') }}" id="img-servidores">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Editar Servidor</h1>
                </div>
    
                {{ Form::model($servidor,['route' => ['servidor.update',$servidor->id], 'method' => "POST"]) }}
                    @csrf
                    @method('PUT')
                    {{ Form::open(['route' => 'servidor.store', 'method' => "POST",'enctype' => "multipart/form-data"]) }}
                        @csrf
                        <div class="mb-3 col-md-8">
                            {{ Form::text('nome', 'old'('nome'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Nome','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('matricula', 'old'('matricula'), ['class' => 'form-control cad-servidor','placeholder' => 'Matrícula','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('cpf', 'old'('cpf'), ['class' => 'form-control cad-servidor cpf','placeholder' => 'CPF','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::email('email', 'old'('email'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'E-mail','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('cargo', 'old'('cargo'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Cargo','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('funcao', 'old'('funcao'), ['class' => 'form-control cad-servidor','placeholder' => 'Função','autofocus']) }}
                        </div>
                        <div class="lign-bottom col-md-8">
                            <button type="submit" class="btn btn-enviar">Enviar</button>
                        </div>
                    {{Form::close()}} 
                {{Form::close()}}  

            </div>
        </div>
    </div>
</div>

@endsection
