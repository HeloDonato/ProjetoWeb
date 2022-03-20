
@extends('layouts.admin')

@section('content')
<div class="container-fluid fundo-TCP">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/portarias2.png') }}" id="img-portarias">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Nova Portaria</h1>
                </div>
    
                {{ Form::open(['route' => 'portaria.store', 'method' => "POST",'enctype' => "multipart/form-data"]) }}
                    @csrf
                    <div class="mb-3 col-md-8">
                        <label>Número da Portaria*</label>
                        {{ Form::number('numPortaria', 'old'('numPortaria'), ['class' => 'form-control cad-servidor', 'required','placeholder' => '0','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Título da Portaria*</label>
                        {{ Form::text('titulo', 'old'('titulo'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Portaria','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <label>Descrição da Portaria*"</label>
                        {{ Form::text('descricao', 'old'('descricao'), ['class' => 'form-control cad-servidor', 'required','placeholder' => 'Descrição da Portaria','autofocus']) }}
                    </div>
                    <div class="mb-3 col-md-8">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tipo">Insira o tipo da Portaria</label>
                                <select name="tipo" id="tipo" class="form-control cad-servidor" required onchange="mostrarData()">
                                    <option value="0">Temporárias</option>
                                    <option value="1">Permanentes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sigilo">Sigilo:</label>
                                <select name="sigilo" id="sigilo" class="form-control cad-servidor" required>
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Data Inicial da Portaria*</label>
                                {{ Form::date('dataInicial', 'old'('dataInicial'), ['class' => 'form-control cad-servidor', 'required','placeholder' => '00/00/0000', 'autofocus']) }}
                            </div>
                            <div class="col-md-6">
                                <label>Data Final da Portaria</label>
                                {{ Form::date('dataFinal', 'old'('dataFinal'), ['class' => 'form-control cad-servidor','placeholder' => '00/00/0000','autofocus', 'id' => 'final']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="tipo">Escolha a origem da Portaria</label>
                        <select name="origem" id="origem" class="form-control cad-servidor" required>
                            <option value="Campus">Campus</option>
                            <option value="Reitoria">Reitoria</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="participantes">Escolha os servidores</label>
                        <select data-live-search="true" name="id_servidor[]" multiple class="form-control cad-servidor chosen-select" required> 
                            <option value="" disabled selected>Selecione </option>
                            @foreach ($servidores as $servidor)
                                <option value="{{$servidor->id}}"> {{$servidor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label for="participantes">Escolha os alunos (se houver)</label>
                        <select data-live-search="true" name="id_aluno[]" multiple class="form-control cad-servidor chosen-select"> 
                            <option value="" disabled selected>Selecione </option>
                            @foreach ($alunos as $aluno)
                                <option value="{{$aluno->id}}"> {{$aluno->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-8" style="color: #fff;">
                        <label>Arquivo da Portaria*</label><br>
                        {{ Form::file('doc')}}
                    </div>
                    <div class="mb-3 col-md-8">
                        <input type="submit" class="btn btn-enviar" value="Criar Portaria">
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        $('select[name=tipo]').on("change", function(){
          var aux = $(this).val();
            if (aux == 0){
                $('#final').prop("disabled", false);
            }else{
                $('#final').prop("disabled", true);
            }
        });
    });
    $('#final').trigger('change');
</script>
@endsection
