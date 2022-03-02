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
                        <a href="{{ route('servidor.editProfile', Auth::user()->id) }}" class="btn btn-pesquisar">Mudar senha</a>
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
                                <th class="col-md-2">CPF</th>
                            @endif
                            <th>E-mail</th>
                            <!--<th>Turma</th> -->
                            @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                <th class="col-md-3">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunos as $aluno)
                            <tr>
                                <td>{{$aluno->matricula}}</td>
                                <td>
                                    <a href="{{ route('servidor.portarias', $aluno->id) }}" class="link-servidor">
                                        {{$aluno->nome}}
                                    </a>
                                </td>
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td><font class="cpf">{{$aluno->cpf}}</font></th>
                                @endif
                                <td class="card-title">{{$aluno->usuario->email}}</td>
                                <!-- <td class="card-title"></td> -->
                                @if(Auth::check() and Auth::user()->tipoGrupo != 'padrao')
                                    <td>
                                        <a href="{{ route('servidor.edit', $aluno->usuario_id) }}" class="btn btn-pesquisar edit-btn" style="margin-bottom:3px">Editar <i class="fas fa-edit"></i></a>
                                        <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modal{{ $aluno->id }}" style="margin-bottom:3px">Excluir <i class="fas fa-trash-alt"></i></a>

                                        <div class="modal fade" id="modal{{ $aluno->id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Servidor: {{ $aluno->nome }}</h5>
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
                                                        <a href="{{ route('aluno.destroy', $aluno->usuario_id) }}" class="btn btn-danger">Excluir</a>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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