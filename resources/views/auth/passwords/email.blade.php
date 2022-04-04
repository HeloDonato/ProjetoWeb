

@extends('layouts.login')

@section('content')

<div class="container-fluid">
    <div class="content">
        <div class="row" style="min-height: 80vh;">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/almenara_vertical_jpg.jpg') }}" id="img-portarias">
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
                        <form method="POST" action="{{ route('password.reset')}}">
                            @csrf
                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror cad-login" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @if(session('error'))
                                        <div>
                                            {{ session('error')}}
                                        </div>
                                    @endif

                                    @if(session('sucess'))
                                        <div>    
                                            {{ session('sucess')}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-4">
                                    <button class="btn btn-voltar">
                                        <a href="{{ route('login') }}" class="link-voltar" style="color:#fff">
                                            {{ __('Voltar para tela de login') }}
                                        </a>
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-entrar">
                                        {{ __('Enviar link de redefinição de senha') }}
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

