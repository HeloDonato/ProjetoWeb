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
            @endphp
            <br><br>
            <h4 style="text-transform: uppercase;">Informações Gerais do número de portarias registradas</h4>
            <h5>Data de emissão do relatório: {{date('d/m/Y',strtotime($data))}} </h5>
            <br>
            <br><br>
            <table class="table table-bordered table-striped col-md-6">
                <tr>
                    <td>
                        <strong>NÚMERO TOTAL DE PORTARIAS</strong>
                    </td>
                    <td>
                        <strong>{{ $total[0]->quantidade}}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>TEMPORÁRIAS</strong>
                    </td>
                    <td>
                        <strong>{{ $temporarias[0]->quantidade }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>PERMANENTES</strong>
                    </td>
                    <td>
                        <strong>{{ $permanentes[0]->quantidade }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>ATIVAS</strong>
                    </td>
                    <td>
                        <strong>{{ $ativas[0]->quantidade }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>INATIVAS</strong>
                    </td>
                    <td>
                        <strong>{{ $inativas[0]->quantidade }}</strong>
                    </td>
                </tr>
            </table>
            <br><br><br>
            <div class="row col-md-12">
                <div class="col-md-6" style="width: 30vw; height:30vw">
                    <canvas id="chart1"></canvas>
                    Temporárias: {{$porcentT}}%  -  Permanentes: {{$porcentP}}%
                </div>
                <div class="col-md-6" style="width: 30vw; height:30vw">
                    <canvas id="chart2"></canvas>
                    Ativas: {{$porcentA}}%  -  Inativas: {{$porcentI}}%
                </div>
            </div>
            
            
        </center>
    </div>
</div>
<script>
    var ctx = document.getElementById('chart1');
    var myChart = new Chart(ctx, {
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
</script>

<script>
    var ctx = document.getElementById('chart2');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ativas', 'Inativas'],
            datasets: [{
                label: 'Ativas e Inativas',
                data: [{{ $ativas[0]->quantidade }}, {{ $inativas[0]->quantidade }}],
                backgroundColor: [
                    'rgba(0, 191, 255, 0.7)',
                    'rgba(139,0,139, 0.9)',
                ],
                borderColor: [
                    'rgba(0, 191, 255, 0.7)',
                    'rgba(139,0,139, 0.9)',
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
