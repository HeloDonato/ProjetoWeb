@extends('layouts.app')

@section('title', 'Portarias')

@section('content')
    <div id="cards-container" class="row" style="min-height:82vh">
        <div class="card-body">
            <div class="row col-md-12 linha-conteudo-options">
                <div class="col-md-4">
                    <a href="" class="link-relatorio" data-toggle="modal" data-target="#relatorioIndividual">
                        <div class="row linha-graficos">
                            <img src="{{ asset('img/grafico01.png') }}" class="icon-grafico">
                        </div>
                        <div class="row nome-grafico" style="justify-content: center;">
                            Relatório Indivudual
                        </div>
                    </a>
                    <div class="modal fade" id="relatorioIndividual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header header-modal-info">
                                    <h5 class="modal-title">Selecione o Servidor</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('relatorios.individual')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                    <select data-live-search="true" name="id_servidor" class="form-control cad-servidor chosen-select">
                                                        <option disabled> Selecione </option>
                                                        <optgroup label="Servidores">
                                                            @foreach ($users as $user)
                                                                @if($user->id !=1)
                                                                    <option value="{{$user->usuario_id}}"> {{$user->nome }}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                        <optgroup label="Alunos">
                                                            @foreach ($alunos as $aluno)
                                                                    <option value="{{$aluno->usuario_id}}"> {{$aluno->nome }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <a target="_blank">
                                                            <button type="submit" class="btn btn-enviar">Gerar Relatório</button>    
                                                        </a>
                                                        
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
                <div class="col-md-4 ">
                    <a href="" class="link-relatorio" data-toggle="modal" data-target="#ranking">
                        <div class="row linha-graficos">
                            <img src="{{ asset('img/grafico02.png') }}" class="icon-grafico">
                        </div>
                        <div class="row nome-grafico" style="justify-content: center;">
                            Rankings
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{route('relatorios.relatorioGeral')}}" class="link-relatorio" target="_blank">
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
    <div class="modal fade" id="ranking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header header-modal-info">
                                    <h5 class="modal-title">Selecione o ranking</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('relatorios.individual')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <a href="{{route('relatorios.ranking')}} "class="btn btn-pesquisar" style="margin-bottom:3px; margin-left:50px;" target="_blank"> Relatório de Servidores</a>
                                                        <a href="{{route('relatorios.rankingA')}}"class="btn btn-pesquisar" style="margin-bottom:3px; margin-left:10px;" target="_blank"> Relatório de Alunos</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection