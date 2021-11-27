
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
    
                {{ Form::model($portaria,['route' => ['portaria.update',$portaria->id], 'method' => "POST"]) }}
                    @csrf
                    @method('PUT')
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
                                        @if($portaria->tipo == 0)
                                            <option value="0" selected>Temporárias</option>
                                            <option value="1">Permanentes</option>
                                        @else
                                            <option value="0">Temporárias</option>
                                            <option value="1" selected>Permanentes</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sigilo">Sigilo:</label>
                                    <select name="sigilo" id="sigilo" class="form-control cad-servidor" required>
                                        @if($portaria->tipo == 0)                                   
                                            <option value="0" selected>Não</option>
                                            <option value="1">Sim</option>
                                        @else                      
                                            <option value="0">Não</option>
                                            <option value="1" selected>Sim</option>
                                        @endif
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
                                    @if($portaria->value == 'Campus')                                                                          
                                        <option value="Campus" selected>Campus</option>
                                        <option value="Portaria">Reitoria</option>
                                    @else                      
                                        <option value="Campus">Campus</option>
                                        <option value="Portaria" selected>Reitoria</option>
                                    @endif
                            </select>
                        </div>
                        @if(Auth::user()->tipoGrupo == 'super')
                            @if($portaria->permaStatus !== null)
                                <div class="form-group col-md-8">
                                    <label for="permaStatus">Status da portaria permanente</label>
                                        <select name="permaStatus" id="permaStatus" class="form-control cad-servidor" require>
                                                @if($portaria->permaStatus == 0)                                                                          
                                                    <option value="0" selected>Ativa</option>
                                                    <option value="1">Inativa</option>
                                                @else                      
                                                    <option value="0">Ativa</option>
                                                    <option value="1" selected>Inativa</option>
                                                @endif
                                        </select>
                                </div>
                            @endif
                        @endif
                        <div class="form-group col-md-8">
                        <label for="participantes">Escolha os servidores</label>
                            <select data-live-search="true" name="id_servidor[]" multiple class="form-control cad-servidor chosen-select">
                                <option disabled> Selecione </option>
                                @foreach ($servidores as $servidor)
                                    <option value="{{$servidor->id}}"> {{$servidor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8" style="color: #fff;">
                            <label>Arquivo da Portaria*</label><br>
                            {{ Form::file('doc')}}
                        </div>
                        <div class="mb-3 col-md-8">
                            <input type="submit" class="btn btn-enviar" value="Salvar Mudanças">
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
        }).change();
    });
    $('#final').trigger('change');
</script>
@endsection
