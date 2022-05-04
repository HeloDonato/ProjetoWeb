
@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="content">
        <div class="row" style="min-height: 80vh;">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/password-reset.png') }}" id="img-reset-password">
                </div>
            </div>
            <div class="col-md-6">
                <div style="min-height:80vh; width:48vw;">
                    <div style="width: 100%; padding-top:20vh">
                        <center>
                            <h1 class="tit-form-login">Recuperação de Senha</h1>
                        </center>
                        <br>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('reset.password.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
    
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control cad-login" name="email" required autofocus placeholder="E-mail">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control cad-login" name="password" placeholder="Nova Senha" required autofocus>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <input type="password" id="password-confirm" class="form-control cad-login" name="password_confirmation" placeholder="Confirmar Senha" required autofocus>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-entrar">
                                        Resetar senha
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection