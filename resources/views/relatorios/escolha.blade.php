@extends('layouts.app')

@section('title', 'Servidores')

@section('content')
    <div id="cards-container" class="row" style="margin-top: 20px; min-height: 82vh;">
        <div class="card-body">  
                <div class="form-group col-md-8">
                    <label for="participantes">Escolha o servidor</label>
                        <select data-live-search="true" name="id_servidor" class="form-control cad-servidor chosen-select">
                            <option disabled> Selecione </option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}"> {{$user->nome }}</option>
                            @endforeach
                        </select>
                </div>
            </ul>
        </div>
    </div>
@endsection