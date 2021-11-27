@extends('layouts.app')

@section('title', 'Portarias')

@section('content')
    <div id="cards-container" class="row" style="min-height:82vh">
        <div class="card-body">
            <div class="row col-md-12 linha-conteudo-options">
                <div class="col-md-4">
                    <a href="{{route('relatorios.options')}}" class="link-relatorio">
                        <div class="row linha-graficos">
                            <img src="{{ asset('img/grafico01.png') }}" class="icon-grafico">
                        </div>
                        <div class="row nome-grafico" style="justify-content: center;">
                            Relatório Indivudual
                        </div>
                    </a>
                </div>
                <div class="col-md-4 ">
                    <a href="{{route('relatorios.ranking')}}" class="link-relatorio">
                        <div class="row linha-graficos">
                            <img src="{{ asset('img/grafico02.png') }}" class="icon-grafico">
                        </div>
                        <div class="row nome-grafico" style="justify-content: center;">
                            Ranking de Servidores
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('relatorios.options')}}" class="link-relatorio">
                        <div class="row linha-graficos">
                            <img src="{{ asset('img/grafico03.png') }}" class="icon-grafico">
                        </div>
                        <div class="row nome-grafico" style="justify-content: center;">
                            Relatório Geral - Portarias
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection