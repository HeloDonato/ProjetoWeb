@extends('layouts.listUsers')

@section('title', 'Servidores')

@section('content')

    @if(Auth::check() && Auth::user()->alter_password == 0)
        <script>
            function abreModal() {
                $("#staticBackdrop").modal({
                    show: true
                });
            }
            setTimeout(abreModal, 1000);
            window.onload = abreModal;
        </script>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header header-modal-info">
                    <h5 class="modal-title" id="staticBackdropLabel">Altere sua senha para continuar!</h5>
                </div>
                <div class="modal-body">
                    Por razões de segurança, altere sua senha para continuar a usar o sistema. 
                </div>
                <div class="modal-footer">
                    @if(Auth::check() && Auth::user()->alter_password == 0)
                        <a href="{{ route('usuario.editProfile', Auth::user()->id) }}" class="btn btn-pesquisar">Mudar senha</a>
                    @else   
                        ''
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="cards-container" class="row" style="margin-top: 20px; min-height: 82vh;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered table-condensed ">
                    <thead>
                        <tr>
                            <th class="col-md-1">Matrícula</th>
                            <th>Nome</th>
                            @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                <th class="col-md-1">CPF</th>
                            @endif
                            <th>E-mail</th>
                            <th>Detalhes</th>
                            @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                <th class="col-md-3">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servidores as $servidor)
                            <tr>
                                <td>{{$servidor->matricula}}</td>
                                <td>
                                    <a href="{{ route('servidor.portarias', $servidor->id) }}" class="link-servidor">
                                        {{$servidor->nome}}
                                    </a>
                                </td>
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td><font class="cpf">{{$servidor->cpf}}</font></th>
                                @endif
                                <td class="card-title">{{$servidor->usuario->email}}</td>
                                <td class="card-title">
                                    <a href="" class="btn btn-pesquisar" data-toggle="modal" data-target="#modal3{{ $servidor->id }}" style="margin-bottom:3px">Info <i class="fas fa-info-circle"></i></a>      

                                    <div class="modal fade" id="modal3{{ $servidor->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header header-modal-info">
                                                    <h5 class="modal-title"><strong>Servidor: </strong>{{ $servidor->nome}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span class="span-modal-info">Cargo:</span> {{$servidor->cargo}}<br><hr>
                                                    <span class="span-modal-info">Função:</span> 
                                                    @if($servidor->funcao == null)
                                                        Sem função registrada
                                                    @else
                                                        {{$servidor->funcao}}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td>
                                        <a href="{{ route('servidor.edit', $servidor->usuario_id) }}" class="btn btn-pesquisar edit-btn" style="margin-bottom:3px">Editar <i class="fas fa-edit"></i></a>
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
                                                        Nome do Servidor: <strong>{{  $servidor->nome }}</strong> <br>
                                                        Matrícula: {{$servidor->matricula}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('servidor.destroy', $servidor->usuario_id) }}" class="btn btn-danger">Excluir</a>
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
                                                            {{ Form::model($servidor,['route' => ['grupo.update', $servidor->usuario_id], 'method' => "PUT"]) }}
                                                                <select name="tipoGrupo" class="form-control">
                                                                    <option value="admin" {{ $servidor->usuario->tipoGrupo == 'admin' ? 'selected' : '' }}> Admin </option>
                                                                    <option value="padrao" {{ $servidor->usuario->tipoGrupo == 'padrao' ? 'selected' : '' }}> Padrão</option>
                                                                    <option value="super" {{ $servidor->usuario->tipoGrupo == 'super' ? 'selected' : '' }}> Super</option>
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
            <div class="div-paginacao">
                @if(isset($filters['search']))
                    {{ $servidores->appends($filters)->links() }}
                @else
                    {{ $servidores->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection