@extends('adminlte::page')

@section('title', 'Gráficas de Tickets')

@section('content_header')
    <h1>Número de Tickets</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tickets por Mes</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Número de Tickets</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTableBody">
                            <!-- Contenido de la tabla será llenado dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Tickets por Mes</h3>
                </div>
                <div class="box-body">
                    <div id="barChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Porcentaje de Tickets por Mes</h3>
                </div>
                <div class="box-body">
                    <div id="pieChart" style="height: 250px;"></div>
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
            fetch("{{ route('charts.data') }}")
                .then(response => response.json())
                .then(data => {
                    // Llenar la tabla
                    const tableBody = document.getElementById('ticketsTableBody');
                    tableBody.innerHTML = '';
                    data.monthlyData.forEach(item => {
                        const row = `<tr><td>${item.month}</td><td>${item.count}</td></tr>`;
                        tableBody.innerHTML += row;
                    });

                    // Array de colores
                    const colors = ['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed', '#61C0BF', '#FFD700', '#FF6347', '#87CEFA', '#FFE4C4'];

                    // Bar Chart
                    new Morris.Bar({
                        element: 'barChart',
                        data: data.monthlyData,
                        xkey: 'month',
                        ykeys: ['count'],
                        labels: ['Tickets'],
                        barColors: function(row, series, type) {
                    return colors[row.x];
                },
                        xLabelAngle: 60
                    });

                    // Donut Chart (Pie Chart)
                    new Morris.Donut({
                        element: 'pieChart',
                        data: data.percentageData,
                        colors: colors /*['#0b62a4', '#7a92a3', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed']*/
                    });
                });
        });
    </script>
@stop
