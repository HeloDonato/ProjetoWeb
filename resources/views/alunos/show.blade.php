@extends('layouts.listAlunos')

@section('title', 'Alunos')

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
                            @if(!Auth::check() or (Auth::check() and Auth::user()->tipoGrupo == 'padrao'))
                                <th>Curso</th>
                                <th class="col-md-1">Turma</th>
                            @endif
                            <th>E-mail</th>
                            @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                <th>CPF</th>
                                <th>Detalhes</th>    
                                <th class="col-md-3">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunos as $aluno)
                            <tr>
                                <td>{{$aluno->matricula}}</td>
                                <td>
                                    <a href="{{ route('aluno.portarias', $aluno->id) }}" class="link-servidor">
                                        {{$aluno->nome}}
                                    </a>
                                </td>
                                @if(!Auth::check() or (Auth::check() and Auth::user()->tipoGrupo == 'padrao'))
                                    <td>{{ $aluno->curso->nome }}</td>
                                    <td>{{ $aluno->turma }}</th>
                                @endif
                                <td class="card-title">{{$aluno->usuario->email}}</td>
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td><font class="cpf">{{$aluno->cpf}}</font></td>
                                    <td class="card-title">
                                        <a href="" class="btn btn-pesquisar" data-toggle="modal" data-target="#modal3{{ $aluno->id }}" style="margin-bottom:3px">Info <i class="fas fa-info-circle"></i></a>      

                                        <div class="modal fade" id="modal3{{ $aluno->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header header-modal-info">
                                                        <h5 class="modal-title"><strong>Aluno: </strong>{{ $aluno->nome}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span class="span-modal-info">Curso:</span> {{$aluno->curso->nome}}<br><hr>
                                                        <span class="span-modal-info">Turma:</span> {{$aluno->turma}} 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('aluno.edit', $aluno->usuario_id) }}" class="btn btn-pesquisar edit-btn" style="margin-bottom:3px">Editar <i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $aluno->id }}" style="margin-bottom:3px">Excluir <i class="fas fa-trash-alt"></i></a>
                                        @if(Auth::user()->tipoGrupo == 'super')
                                            <a href="" class="btn btn-secondary" data-toggle="modal" data-target="#modal2{{ $aluno->id }}" style="margin-bottom:3px">Acesso <i class="fas fa-user-shield"></i></a>      
                                        @endif

                                        <div class="modal fade" id="modal{{ $aluno->id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Aluno: {{ $aluno->nome }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        O registro selecionado será excluído, deseja prosseguir?
                                                        <br>
                                                        Nome do Aluno: <strong>{{  $aluno->nome }}</strong> <br>
                                                        Matrícula: {{$aluno->matricula}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('servidor.destroy', $aluno->usuario_id) }}" class="btn btn-danger">Excluir</a>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if(Auth::user()->tipoGrupo == 'super')
                                            <div class="modal fade modal-info" id="modal2{{ $aluno->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header header-modal-info">
                                                            <h5 class="modal-title" id="exampleModalLabel">Nível de acesso de usuário</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ Form::model($aluno,['route' => ['grupo.update', $aluno->usuario_id], 'method' => "PUT"]) }}
                                                            <select name="tipoGrupo" class="form-control">
                                                                <option value="admin" {{ $aluno->usuario->tipoGrupo == 'admin' ? 'selected' : '' }}> Admin </option>
                                                                <option value="padrao" {{ $aluno->usuario->tipoGrupo == 'padrao' ? 'selected' : '' }}> Padrão</option>
                                                                <option value="super" {{ $aluno->usuario->tipoGrupo == 'super' ? 'selected' : '' }}> Super</option>
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
                    {{ $alunos->appends($filters)->links() }}
                @else
                    {{ $alunos->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection