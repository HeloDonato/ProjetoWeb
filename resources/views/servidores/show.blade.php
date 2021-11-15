@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
    <div id="cards-container" class="row" style="margin-top: 20px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered table-condensed ">
                    <thead>
                        <tr>
                            <th class="col-md-1">Matrícula</th>
                            <th>Nome</th>
                            <th class="col-md-1">CPF</th>
                            <th>E-mail</th>
                            <th class="col-md-1">Cargo</th>
                            <th class="col-md-2">Função</th>
                            <th class="col-md-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidores as $servidor)
                            <tr>
                                <td>num matricula</td>
                                <td>{{$servidor->nome}} {{$servidor->sobrenome}}</td>
                                <td>aqui fica o CPF</td>
                                <td class="card-title">{{$servidor->email}}</td>
                                <td class="card-title">{{$servidor->cargo}}</td>
                                <td class="card-title">aqui fica a função</td>
                                <td>
                                    <a href="#" class="btn btn-pesquisar edit-btn">Editar <i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-danger" data-toggle="modal" data-target="teste">Excluir <i class="fas fa-trash-alt"></i></a>      

                                    <div class="modal fade" id="teste" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Título da Portaria: {{ $servidor->nome }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    O registro selecionado será excluído, deseja prosseguir?
                                                    <br>
                                                    Nome do Servidor: <strong>{{  $servidor->nome }} {{$servidor->sobrenome}}</strong> <br>
                                                    Matrícula: 
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#" class="btn btn-danger">Excluir</a>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection