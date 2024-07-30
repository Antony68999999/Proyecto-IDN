@extends('adminlte::page')

@section('title', 'Gráficas de Incidencias')

@section('content_header')
    <h1>Gráficas de Incidencias</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabla de Incidencias</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Sistema</th>
                                <th>Usuario</th>
                                <th>Otros</th>
                                <th>Total por Mes</th>
                            </tr>
                        </thead>
                        <tbody id="incidencesTableBody">
                            <!-- Contenido de la tabla será llenado dinámicamente -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="totalSistema">0</th>
                                <th id="totalUsuario">0</th>
                                <th id="totalOtros">0</th>
                                <th id="totalGeneral">0</th>
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
                    <h3 class="box-title">Gráfica de Incidencias por Mes</h3>
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
            fetch("{{ route('incidence.data') }}")
                .then(response => response.json())
                .then(data => {
                    // Llenar la tabla
                    const tableBody = document.getElementById('incidencesTableBody');
                    tableBody.innerHTML = '';
                    data.tableData.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.month}</td>
                                <td>${item.Sistema}</td>
                                <td>${item.Usuario}</td>
                                <td>${item.Otros}</td>
                                <td>${item.total}</td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });

                    // Totales por tipo
                    document.getElementById('totalSistema').innerText = data.totalsByType.Sistema;
                    document.getElementById('totalUsuario').innerText = data.totalsByType.Usuario;
                    document.getElementById('totalOtros').innerText = data.totalsByType.Otros;
                    document.getElementById('totalGeneral').innerText = data.totalsByType.Sistema + data.totalsByType.Usuario + data.totalsByType.Otros;

                    // Organizar datos para la gráfica
                    const stackedData = data.graphData.map(item => ({
                        month: item.month,
                        Sistema: item.Sistema,
                        Usuario: item.Usuario,
                        Otros: item.Otros
                    }));

                    // Crear la gráfica de barras horizontales apiladas
                    new Morris.Bar({
                        element: 'stackedBarChart',
                        data: stackedData,
                        xkey: 'month',
                        ykeys: ['Sistema', 'Usuario', 'Otros'],
                        labels: ['Sistema', 'Usuario', 'Otros'],
                        stacked: true,
                        horizontal: true,
                        barColors: ['#0b62a4', '#7a92a3', '#4da74d'],
                        xLabelAngle: 30,
                        resize: true
                    });
                });
        });
    </script>
@stop
