@extends('adminlte::page')

@section('title', 'Horas de Incidencias')

@section('content_header')
    <h1>Horas de Incidencias</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabla de Horas de Incidencias</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Horas Sistema</th>
                                <th>Horas Usuario</th>
                                <th>Horas Otros</th>
                                <th>Total Horas por Mes</th>
                            </tr>
                        </thead>
                        <tbody id="incidencesHoursTableBody">
                            <!-- Contenido de la tabla será llenado dinámicamente -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="totalSistemaTiempo">0</th>
                                <th id="totalUsuarioTiempo">0</th>
                                <th id="totalOtrosTiempo">0</th>
                                <th id="totalGeneralTiempo">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Gráfica de Horas de Incidencias por Mes</h3>
                </div>
                <div class="box-body">
                    <div id="stackedBarChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('js')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('incidence.hours.data') }}")
                .then(response => response.json())
                .then(data => {
                    // Llenar la tabla
                    const tableBody = document.getElementById('incidencesHoursTableBody');
                    tableBody.innerHTML = '';
                    data.tableData.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.month}</td>
                                <td>${item.SistemaTiempo}</td>
                                <td>${item.UsuarioTiempo}</td>
                                <td>${item.OtrosTiempo}</td>
                                <td>${item.totalTiempo}</td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });

                    // Totales por tipo
                    document.getElementById('totalSistemaTiempo').innerText = data.totalsByType.SistemaTiempo;
                    document.getElementById('totalUsuarioTiempo').innerText = data.totalsByType.UsuarioTiempo;
                    document.getElementById('totalOtrosTiempo').innerText = data.totalsByType.OtrosTiempo;
                    document.getElementById('totalGeneralTiempo').innerText = data.totalsByType.SistemaTiempo + data.totalsByType.UsuarioTiempo + data.totalsByType.OtrosTiempo;

                    // Reorganizar datos para la gráfica
                    const stackedData = data.graphData.map(item => ({
                        
                            month: item.month,
                            SistemaTiempo: item.SistemaTiempo,
                            UsuarioTiempo: item.UsuarioTiempo,
                            OtrosTiempo: item.OtrosTiempo
                       
                    }));

                    // Gráfica de barras apiladas horizontal
                    new Morris.Bar({
                        element: 'stackedBarChart',
                        data: stackedData,
                        xkey: 'month',
                        ykeys: ['SistemaTiempo', 'UsuarioTiempo', 'OtrosTiempo'],
                        labels: ['Sistema', 'Usuario', 'Otros'],
                        stacked: true,
                        barColors: ['#0b62a4', '#7a92a3', '#4da74d']
                    });
                });
        });
    </script>
@stop
