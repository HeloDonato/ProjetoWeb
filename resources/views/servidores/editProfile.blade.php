
@extends('layouts.admin')

@section('content')
<div class="container-fluid fundo-TCS">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/cadeado.png') }}" id="img-cadeado">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Alterar Senha</h1>
                </div>
    
                {{ Form::model($servidor,['route' => ['servidor.updateProfile',$servidor->id], 'method' => "PUT"]) }}
                    @method('PUT')
                    @csrf
                        <div class="mb-3 col-md-8">
                            {{ Form::password('newPassword', 'old'('newPassword'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Nova Senha','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::password('confirmaSenha', 'old'('confirmaSenha'), ['class' => 'form-control cad-servidor','placeholder' => 'Confirme a nova senha','autofocus']) }}
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
