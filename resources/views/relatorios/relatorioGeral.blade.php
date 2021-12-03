<title>Relatório</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script>
    function set() {
        var el = document.getElementById('no-print');
        el.style.display = 'none';
    }
    function setVis() {
        var el = document.getElementById('no-print');
        el.style.display = 'block';
    }
</script>
<br><br>
<div class="col-md-12 text-center" id="no-print">
    <center>
        <button class="btn btn-primary no-print" onclick="set();window.print();setVis()">Imprimir</button>
        <a href="{{ url()->previous() }}">
            <button class="btn btn-primary">Voltar</button>
        </a>
    </center>
    <br><br>
</div>
<div class="container">
    <div class="container" style="width: 100%;">
        <img class="if" src="{{ asset('img/almenara_horizontal_jpg.jpg') }}" style="width: 390px; height:140px" />
        <center>
            @php
                $data = date('Y-m-d');
            @endphp
            <br><br>
            <h4 style="text-transform: uppercase;">Relatório Geral de portarias registradas</h4>
            <h5>Data de emissão do relatório: {{date('d/m/Y',strtotime($data))}} </h5>
            <br><br><br>
            
            <h4>Número de registros: <strong>{{ $total[0]->quantidade}}</strong></h4><hr><br>
            <div>
                <div class="row col-md-12">
                    <table class="table table-bordered table-striped col-md-12">
                        <tr>
                            <td class="col-md-8">
                                <strong><center>TIPO DE PORTARIA QUANTO AO TEMPO</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>QUANTIDADE</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>PORCENTAGEM(%)</center></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>TEMPORÁRIAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;"> 
                                <strong>{{ $temporarias[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentTemp']}}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>PERMANENTES</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $permanentes[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentPerm']}}%</strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart1"></canvas>
                        Temporárias: {{$porcentagem['porcentTemp']}}%  -  Permanentes: {{$porcentagem['porcentPerm']}}%
                    </div>
                </div>
            </div>
            <br><br>

            <div>
                <div class="row col-md-12">
                    <table class="table table-bordered table-striped col-md-12">
                        <tr>
                            <td class="col-md-8">
                                <strong><center>STATUS DAS PORTARIAS</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>QUANTIDADE</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>PORCENTAGEM(%)</center></strong>
                            </td>
                        </tr>    
                        <tr>
                            <td class="col-md-8">
                                <strong>ATIVAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $ativas[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentAtivas']}}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>INATIVAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $inativas[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentInativas']}}%</strong>
                            </td>
                        </tr>
                    </table><br>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart2"></canvas>
                        Ativas: {{$porcentagem['porcentAtivas']}}%  -  Inativas: {{$porcentagem['porcentInativas']}}%
                    </div>
                </div>
            </div>        
            <br><br>
            
            <div>
                <div class="row col-md-12">
                    <table class="table table-bordered table-striped col-md-12">
                        <tr>
                            <td class="col-md-8">
                                <strong><center>ORIGEM DAS PORTARIAS</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>QUANTIDADE</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>PORCENTAGEM(%)</center></strong>
                            </td>
                        </tr> 
                        <tr>
                            <td class="col-md-8">
                                <strong>CAMPUS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $campus[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentCampus']}}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>REITORIA</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $reitoria[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentReitoria']}}%</strong>
                            </td>
                        </tr>
                    </table><br>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart3"></canvas>
                        Campus: {{$porcentagem['porcentCampus']}}%  -  Reitoria: {{$porcentagem['porcentReitoria']}}%
                    </div>
                </div>
            </div>        
            <br><br>

            <div class="row col-md-12">
                    <table class="table table-bordered table-striped col-md-12">
                        <tr>
                            <td class="col-md-8">
                                <strong><center>TIPO DE PORTARIA QUANTO AO SIGILO</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>QUANTIDADE</center></strong>
                            </td>
                            <td class="col-md-2">
                                <strong><center>PORCENTAGEM(%)</center></strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>PÚBLICAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $publicas[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentPublicas']}}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>SIGILOSAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $sigilosas[0]->quantidade }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{$porcentagem['porcentSigilosas']}}%</strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart4"></canvas>
                        Públicas: {{$porcentagem['porcentPublicas']}}%  -  Sigilosas: {{$porcentagem['porcentSigilosas']}}%
                    </div>
                </div>
            </div>
            <br><br>
            
        </center>
    </div>
</div>
<script>
    var g1 = document.getElementById('chart1');
    var myChart = new Chart(g1, {
        type: 'pie',
        data: {
            labels: ['Temporárias', 'Permanentes'],
            datasets: [{
                label: 'Temporárias e Permanentes',
                data: [{{ $temporarias[0]->quantidade }}, {{ $permanentes[0]->quantidade }}],
                backgroundColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var g2 = document.getElementById('chart2');
    var myChart = new Chart(g2, {
        type: 'pie',
        data: {
            labels: ['Ativas', 'Inativas'],
            datasets: [{
                label: 'Ativas e Inativas',
                data: [{{ $ativas[0]->quantidade }}, {{ $inativas[0]->quantidade }}],
                backgroundColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var g3 = document.getElementById('chart3');
    var myChart = new Chart(g3, {
        type: 'pie',
        data: {
            labels: ['Campus', 'Reitoria'],
            datasets: [{
                label: 'Campus e Reitoria',
                data: [{{ $campus[0]->quantidade }}, {{ $reitoria[0]->quantidade }}],
                backgroundColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var g4 = document.getElementById('chart4');
    var myChart = new Chart(g4, {
        type: 'pie',
        data: {
            labels: ['Públicas', 'Sigilosas'],
            datasets: [{
                label: 'Públicas e Sigilosas',
                data: [{{ $publicas[0]->quantidade }}, {{ $sigilosas[0]->quantidade }}],
                backgroundColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderColor: [
                    'rgba(79, 167, 92, 0.7)',
                    'rgba(1, 81, 96, 0.9)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
