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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/config.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <a class="link" href="{{ url('/') }}">
                Portarias
            </a>
            <div class="container">
            <form action="/home" method="GET" class="d-flex">
                <div class="input-group">
                    <input id="search" name="search" class="form-control" type="text" placeholder="Pesquisar" >
                    <div class="input-group-append">
                        <a href="{{url('homeA')}}" class="btn btn-info">Pesquisar</a>
                    </div>
                </div>
            </form>
            <div>
                <ul class="navbar-nav mr-auto">

                </ul>
            
                <ul class="nav justify-content-center">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-success" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('portaria.create') }}">{{ __('Criar Portaria') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('portaria.myportarias') }}">{{ __('Minhas Portarias') }}</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown " class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
        @if($search)
            <h2>Buscando por: {{$search}}</h2>
        @endif

        <main>
            @yield('content')
        </main>

        <footer class="text-center text-lg-start fixed-bottom">
            IFNMG - Campus Almenara
        </footer>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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
           
    @if(count($portaria) == 0 && $search)
        <p>Não foi possível encontrar nenhuma portaria com {{$search}}!, <a href="/">Ver outras Portarias</a> </p>
    @elseif(count($portaria) == 0)
        <p>Não há portarias disponíveis, <a href="{{route('portaria.create')}}">Criar Portarias</a></p>
    @endif
</body>
</html>
