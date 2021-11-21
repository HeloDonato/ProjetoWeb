@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
    <div id="cards-container" class="row" style="margin-top: 20px; min-height: 82vh;">
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
                            @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                <th class="col-md-3">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidores as $servidor)
                            <tr>
                                <td>{{$servidor->matricula}}</td>
                                <td><a href="{{ route('servidor.portarias', $servidor->id) }}">{{$servidor->nome}} {{$servidor->sobrenome}}</a></td>
                                <td>{{$servidor->cpf}}</td>
                                <td class="card-title">{{$servidor->email}}</td>
                                <td class="card-title">{{$servidor->cargo}}</td>
                                <td class="card-title">{{$servidor->funcao}}</td>
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td>
                                        <a href="{{ route('servidor.edit', $servidor->id) }}" class="btn btn-pesquisar edit-btn" style="margin-bottom:3px">Editar <i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $servidor->id }}" style="margin-bottom:3px">Excluir <i class="fas fa-trash-alt"></i></a>
                                        @if(Auth::user()->tipoGrupo == 'super')
                                            <a href="" class="btn btn-secondary" data-toggle="modal" data-target="#modal2{{ $servidor->id }}" style="margin-bottom:3px">Acesso <i class="fas fa-user-shield"></i></a>      
                                        @endif

                                        <div class="modal fade" id="modal{{ $servidor->id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Servidor: {{ $servidor->nome }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        O registro selecionado será excluído, deseja prosseguir?
                                                        <br>
                                                        Nome do Servidor: <strong>{{  $servidor->nome }} {{$servidor->sobrenome}}</strong> <br>
                                                        Matrícula: {{$servidor->matricula}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('servidor.destroy', $servidor->id) }}" class="btn btn-danger">Excluir</a>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(Auth::user()->tipoGrupo == 'super')
                                            <div class="modal fade modal-info" id="modal2{{ $servidor->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header header-modal-info">
                                                            <h5 class="modal-title" id="exampleModalLabel">Nível de acesso de usuário</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ Form::model($servidor,['route' => ['grupo.update', $servidor->id], 'method' => "PUT"]) }}
                                                            <select name="tipoGrupo" class="form-control">
                                                                <option value="admin">Admin </option>
                                                                <option value="padrao">Padrão</option>
                                                                <option value="super">Super</option>
                                                            </select>
                                                            <input type="submit" class="btn btn-enviar" value="Alterar">
                                                            {{Form::close()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    </tbody> 
                </table>
            </div>
        </div>
    </div>

@endsection