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
                            <h1 class="tit-form-login">Login</h1>
                        </center>
                       
                        <form method="POST" action="{{ route('login') }}" >
                            @csrf
                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <input id="email" type="email" placeholder="Email" autofocus="none" class="form-control cad-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ 'Email ou senha incorretos!' }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <input id="password"  placeholder="Senha" type="password" class="form-control cad-login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-entrar">
                                        {{ __('Entrar') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="form-check">
                                            <input  type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class=" text-dark" for="remember">
                                                {{ __('Lembrar-me') }}
                                            </label>
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('forget.password.get') }}">
                                                    {{ __('Alterar Senha') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
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