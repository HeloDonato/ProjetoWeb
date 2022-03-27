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
        <img class="if" src="{{ asset('img/almenara_horizontal_jpg.jpg') }}" style="width: 43%; height:15%" />
        <center>
            @php
                $data = date('Y-m-d');
                $total = $portaria->portariasTotais($servidor->id);
                $temp = $portaria->portariasTemporarias($servidor->id);
                $perm = $portaria->portariasPermanentes($servidor->id);
                $ativas = $portaria->portariasAtivas($servidor->id, $data);
                $inativas = $portaria->portariasInativas($servidor->id, $data);
                $publicas = $portaria->portariasPublicas($servidor->id);
                $sigilosas = $portaria->portariasSigilosas($servidor->id);
                $campus = $portaria->portariasCampus($servidor->id);
                $reitoria = $portaria->portariasReitoria($servidor->id);
                if($total == 0){
                    $porcentT = 0;
                    $porcentPer = 0;
                    $porcentA = 0;
                    $porcentI = 0;
                    $porcentPub = 0;
                    $porcentS = 0;
                    $porcentC = 0;
                    $porcentR = 0;
                }else{
                    $porcentT = number_format(($temp/$total*100), 2, '.', '');
                    $porcentPer = number_format(($perm/$total*100), 2, '.', '');
                    $porcentA = number_format(($ativas/$total*100), 2, '.', '');
                    $porcentI = number_format(($inativas/$total*100), 2, '.', '');
                    $porcentPub = number_format(($publicas/$total*100), 2, '.', '');
                    $porcentS = number_format(($sigilosas/$total*100), 2, '.', '');
                    $porcentC = number_format(($campus/$total*100), 2, '.', '');
                    $porcentR = number_format(($reitoria/$total*100), 2, '.', '');
                }
            @endphp
            <br><br>

            <h4 style="text-transform: uppercase;">Relatório de Participação em portarias</h4>
            <h5>Nome do Servidor: {{$servidor->nome}} </h5>
            <h5>Número de Matrícula: {{$servidor->matricula}}</h5>
            <h5>Data de emissão do relatório: {{date('d/m/Y',strtotime($data))}} </h5>
            
            <br><br><br>

            <h4>Número de registros: <strong>{{ $total }}</strong></h4><hr><br>
            
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
                                <strong>{{ $temp }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentT }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>PERMANENTES</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $perm }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentPer }}%</strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart1"></canvas>
                        Temporárias: {{ $porcentT }}%  -  Permanentes: {{ $porcentPer }}%
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
                                <strong>{{ $ativas }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentA }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>INATIVAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $inativas }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentI }}%</strong>
                            </td>
                        </tr>
                    </table><br>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart2"></canvas>
                        Ativas: {{ $porcentA }}%  -  Inativas: {{ $porcentI }}}%
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
                                <strong>{{ $campus }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentC }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>REITORIA</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $reitoria }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentR }}%</strong>
                            </td>
                        </tr>
                    </table><br>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart3"></canvas>
                        Campus: {{ $porcentC }}%  -  Reitoria: {{ $porcentR }}%
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
                                <strong>{{ $publicas }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentPub }}%</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-8">
                                <strong>SIGILOSAS</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $sigilosas }}</strong>
                            </td>
                            <td class="col-md-2" style="text-align: right;">
                                <strong>{{ $porcentS }}%</strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="row col-md-12" style="justify-content: center;">
                    <div class="col-md-6">
                        <canvas id="chart4"></canvas>
                        Públicas: {{ $porcentPub }}%  -  Sigilosas: {{ $porcentS }}%
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
                data: [{{ $temp }}, {{ $perm }}],
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
                data: [{{ $ativas }}, {{ $inativas }}],
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
                data: [{{ $campus }}, {{ $reitoria }}],
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
                data: [{{ $publicas }}, {{ $sigilosas }}],
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