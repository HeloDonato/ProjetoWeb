@extends('layouts.login')

@section('content')

<div class="container-fluid">
    <div class="content-login" style="justify-content: center;">
        <div class="row-form">
            <div class="col-md-12 col-form-login">
                <div class="tit-form">
                    <h1 class="tit-form-login">Login</h1>
                </div>
    
                <form method="POST" action="{{ route('login') }}" class="formulario-login">
                    @csrf

                    <div class="form-group row justify-content-center">
                        <div class="col-md-5">
                            <input id="email" type="email" placeholder="Email" autofocus="none" class="form-control cad-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ 'Email ou senha incorretos!' }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        
                        <div class="col-md-5">
                            <input id="password"  placeholder="Senha" type="password" class="form-control cad-login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label text-dark" for="remember">
                                    {{ __('Lembrar-me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-md-5 last-line-form-login">
                            <button type="submit" class="btn btn-entrar">
                                {{ __('Entrar') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-entrar" href="{{ route('password.request') }}">
                                    {{ __('Alterar Senha') }}
                                </a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection