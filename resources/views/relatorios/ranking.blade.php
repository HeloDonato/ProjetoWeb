<title>Relatório</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    function set() {
        var el = document.getElementById('no-print');
        el.style.display = 'none';
    }
    function setVis() {
        var el = document.getElementById('no-print');
        el.style.display = 'block';
    }
    function aviso(){
        alert("Clique na coluna que deseja usar como parâmetro de ordenação!");
    }
    function info(n){
        var info = document.getElementById('info-listagem');
        if(n == 1){
            info.innerHTML = "Ordenação por: número total de portarias"
        }else if(n == 2){
            info.innerHTML = "Ordenação por: número de portarias temporárias"
        }else if(n == 3){
            info.innerHTML = "Ordenação por: número de portarias permanentes"
        }else if(n == 4){
            info.innerHTML = "Ordenação por: número de portarias ativas"
        }else if(n == 5){
            info.innerHTML = "Ordenação por: número de portarias inativas"
        }
    }
    window.onload = aviso;
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
<div class="container" onload="aviso()">
    <div class="container" style="width: 100%;">
        <img class="if" src="{{ asset('img/almenara_horizontal_jpg.jpg') }}" style="width: 43%; height:15%" />
        <center>
            <br><br>
            <h4 style="text-transform: uppercase;">Listagem de servidores por quantidade de portarias registradas</h4>
            <h5 id="info-listagem"></h5>
            <br>
            <br><br>
            <table class="table table-hover table-striped table-bordered table-condensed" id="myTable2">
                <thead>
                    <tr>
                        <th class="col-md-6">
                            <strong>SERVIDOR</strong>
                        </th>
                        <a>
                        <th class="col-md-1 titleColum" onclick="sortTable(1), info(1)" style="cursor:pointer;">
                            <strong>Nº TOTAL</strong>
                        </th>
                        </a>
                        <th class="col-md-1 titleColum" onclick="sortTable(2), info(2)" style="cursor:pointer;">
                            <strong>TEMPORÁRIAS</strong>
                        </th>
                        <th class="col-md-1 titleColum" onclick="sortTable(3), info(3)" style="cursor:pointer;">
                            <strong>PERMANENTES</strong>
                        </th>
                        <th class="col-md-1 titleColum" onclick="sortTable(4), info(4)" style="cursor:pointer;">
                            <strong>ATIVAS</strong>
                        </th>
                        <th class="col-md-1 titleColum" onclick="sortTable(5), info(5)" style="cursor:pointer;">
                            <strong>INATIVAS</strong>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servidores as $servidor)
                        @if($servidor->id !=1)
                            <tr>
                                <td class="col-md-6 text-left">
                                    {{ $servidor->nome }} {{ $servidor->sobrenome }}
                                </td>
                                <td class="col-md-1">
                                    {{ $servidor->portariasTotais($servidor->id)}}
                                </td>
                                <td class="col-md-1">
                                    {{ $servidor->portariasTemporarias($servidor->id) }}
                                </td>
                                <td class="col-md-1">
                                    {{ $servidor->portariasPermanentes($servidor->id) }}
                                </td>
                                <td class="col-md-1">
                                    {{ $servidor->portariasAtivas($servidor->id, $mytime = date('Y-m-d')) }}
                                </td>
                                <td class="col-md-1">
                                    {{ $servidor->portariasInativas($servidor->id, $mytime = date('Y-m-d')) }}
                                </td>
                            </tr>
                            @endif  
                    @endforeach
                </tbody>
            </table>
        </center>
    </div>
</div>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable2");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "desc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (Number(x.innerHTML) > Number(y.innerHTML)) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                    }
                } else if (dir == "desc") {
                    if (Number(x.innerHTML) < Number(y.innerHTML)) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "desc") {
                    dir = "asc";
                    switching = true;
                }
            }
        }
    }
</script>