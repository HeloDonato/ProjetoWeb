
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
    
                {{ Form::model(['route' => ['servidor.updateProfile'], 'method' => "POST"]) }}
                    @csrf
                    @method('PUT')
                    {{ Form::open(['route' => 'servidor.store', 'method' => "POST",'enctype' => "multipart/form-data"]) }}
                        @csrf
                        <div class="mb-3 col-md-8">
                            {{ Form::text('old_password', 'old'('old_password'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Senha Antiga','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('new_password', 'old'('new_password'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Nova Senha','autofocus']) }}
                        </div>
                        <div class="mb-3 col-md-8">
                            {{ Form::text('confirm_password', 'old'('confirm_password'), ['class' => 'form-control cad-servidor','placeholder' => 'Confirme a nova senha','autofocus']) }}
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
