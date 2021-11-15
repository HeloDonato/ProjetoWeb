<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md" style="justify-content:space-between">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('Portarias', 'Portarias') }}
                </a>
            </div>

            <div class="container">
                <form action="/" method="GET" class="form-pesquisa">
                    <div class="input-group">
                        <input id="search" name="search" class="form-control" type="text" placeholder="Pesquisar" >
                        <button type="submit" class="btn btn-pesquisar">Pesquisar</button>
                    </div>
                </form>
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
                                <a class="nav-link" href="{{ route('portaria.myportarias') }}">{{ __('Minhas Portarias') }}</a>
                            </li>

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
                                        <a class="dropdown-item" href="{{ route('servidor.show') }}">
                                            {{ __('Listar Servidores') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                        {{ __('Relatórios') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        @if($search ?? '')
            <div class="msg-buscando">
                Buscando por: <span class="ident-pesquisa">{{$search ?? ''}}</span>
            </div>
            
        @endif

        <main>
            @yield('content')
        </main>

        <footer class="text-center text-lg-start fixed-bottom">
            IFNMG - Campus Almenara
        </footer>
    </div>
    
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
    </main>      
           
    @if(count($portaria) == 0 && $search ?? '')
        <p>Não foi possível encontrar nenhuma portaria com {{$search ?? ''}}!, <a href="/">Ver outras Portarias</a> </p>
    @elseif(count($portaria) == 0)
        <p>Não há portarias disponíveis, <a href="{{route('portaria.create')}}">Criar Portarias</a></p>
    @endif
</body>
</html>
