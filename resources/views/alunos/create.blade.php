
@extends('layouts.admin')

@section('content')
<div class="container-fluid fundo-TCS">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/alunos2.png') }}" id="img-alunos">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Novo Aluno</h1>
                </div>
    
                {{ Form::open(['route' => 'aluno.store', 'method' => "POST"]) }}
                    <div class="mb-3 col-md-8">
                        {{ Form::text('nome', 'old'('nome'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Nome Completo','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        {{ Form::text('matricula', 'old'('matricula'), ['class' => 'form-control cad-servidor','placeholder' => 'Matrícula','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        {{ Form::text('cpf', 'old'('cpf'), ['class' => 'form-control cpf cad-servidor','placeholder' => 'CPF','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        {{ Form::email('email', 'old'('email'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'E-mail','autofocus']) }}
                    </div>
                    <div class="form-group col-md-8">   
                        <div class="row">
                            <div class='col-md-1' style="padding-top: 7px; color:#fff">
                                <a data-toggle="modal" data-target="#modal" style="margin-bottom:3px"> <i class="fas fa-plus fa-lg"></i></a>
                            </div>
                            <div class='col-md-11'>     
                                <select data-live-search="true" name="curso" class="form-control cad-servidor" required> 
                                    <option value="" disabled selected>Selecione o curso</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{$curso->id}}"> {{$curso->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-8">
                        {{ Form::text('turma', 'old'('turma'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Turma','autofocus']) }}
                    </div>
                    <div class="lign-bottom col-md-8">
                        <button type="submit" class="btn btn-enviar">Enviar</button>
                    </div>
                {{Form::close()}}  
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header header-modal-info">
                                    <h5 class="modal-title"><strong>Adicionar Curso </strong></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{ Form::open(['route' => 'curso.store', 'method' => "POST"]) }}
                                        <div class="mb-3 col-md-12">
                                            {{ Form::text('nome', 'old'('nome'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Nome do curso','autofocus']) }}
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            {{ Form::text('descricao', 'old'('descricao'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Descrição do curso','autofocus']) }}
                                        </div>
                                        <div class="lign-bottom col-md-12">
                                            <button type="submit" class="btn btn-enviar">Enviar</button>
                                        </div>
                                    {{Form::close()}}  
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
