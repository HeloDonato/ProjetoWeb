<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portarias</title>

    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js" defer></script>
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js" defer></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        $(function() {
            $('.chosen-select').chosen();
            $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        });
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/config.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script>
        $(document).ready(function($){
            var $cpf = $(".cpf");
            $cpf.mask('000.000.000-00', {reverse: true});
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md" style="justify-content:space-between">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img src="{{ asset('img/log_almenara_png.png') }}" class="logo_almenara"/>
                </a>
            </div>
                
            <div class="container">
                <div class="navbar-conteudo">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="justify-content: right">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt nav-icon fa-lg"></i> {{ __('Entrar') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('servidor.show') }}">{{ __('Servidores') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('aluno.show') }}">{{ __('Alunos') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('portaria.myportarias') }}">{{ __('Minhas Portarias') }}</a>
                            </li>
                            @if(Auth::user()->tipoGrupo != 'padrao')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Ferramentas
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('portaria.create') }}">
                                                {{ __('Cadastrar Portaria') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('servidor.create') }}">
                                                {{ __('Cadastrar Servidor') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('aluno.create') }}">
                                                {{ __('Cadastrar Aluno') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('relatorios.options')}}">
                                            {{ __('Relat??rios') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif    
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Perfil
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('usuario.editProfile', Auth::user()->id) }}">
                                        {{ __('Seguran??a') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Sair') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>

            <div class="container-fluid">
                <div class="row">
                    @if(session('msg'))
                        <p class="msg">{{session('msg')}}</p>
                    @endif
                    @if(session('msgE'))
                        <p class="msgE">{{session('msgE')}}</p>
                    @endif
                </div>
            </div>

            @yield('content')
        </main>

        <footer class="text-center text-lg-start">
            Rodovia BR 367 Almenara/Jequitinhonha, km 111, Zona Rural, Almenara-MG - CEP:39900-000 <br>
            Fone: (038) 3218-7385 - Email: comunicacao.almenara@ifnmg.edu.br
        </footer>
    </div>
</body>
</html>
