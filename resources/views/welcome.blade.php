@extends('layouts.home')

@section('title', 'Portarias IFNMG')

@section('content')
        <div id="cards-container" class="row">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-condensed ">
                            <thead>
                                <tr >
                                    <th>Nº da Portaria</th>
                                    <th>Título da Portaria</th>
                                    <th>Descrição da Portaria</th>
                                    <th>Data Inicial</th>
                                    <th>Data Final</th>
                                    <th>Autor</th>
                                    <th>Informações</th>
                                </tr>
                            </thead>
                            @foreach ($portaria as $portarias)
                                <tbody>
                                    <tr>
                                        <td>{{$portarias->numPortaria}}</td>
                                        <td class="card-title">{{$portarias->titulo}}</td>
                                        <td class="card-date">{{$portarias->descricao}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataInicial))}}</td>
                                        <td class="card-date">{{date('d/m/Y',strtotime($portarias->dataFinal))}}</td>
                                        <td class="card-title">{{$portarias->user->name}} {{$portarias->user->sobrenome}}</td>
                                        <td class="car-title">
                                            <a href="{{route('portaria.view',$portarias->doc)}}" class="btn btn-info edit-btn" target="_blank">Visualizar</a>
                                            <a href="{{route('portaria.download',$portarias->doc)}}" class="btn btn-info edit-btn">Baixar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </div>
                    </div>
        </div>
    </div>
@endsection