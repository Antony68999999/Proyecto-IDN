@extends('adminlte::page')

@section('title', 'Reporte de Soportes')

@section('content_header')
    <h1>Reporte de Soportes por Empresa</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabla de Soportes</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Mes</th>
                                <th>Empresa</th>
                                <th>Soportes</th>
                                <th>Total de Soportes</th>
                                <th>Tiempo en Horas</th>
                            </tr>
                        </thead>
                        <tbody id="incidencesTableBody">
                            <!-- Contenido de la tabla será llenado dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Formulario para cálculo de porcentajes -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Calcular Porcentajes</h3>
                </div>
                <div class="box-body">
                    <form id="calculatePercentagesForm">
                        <div class="form-group">
                            <label for="empresa_id">Empresa:</label>
                            <select id="empresa_id" name="empresa_id" class="form-control">
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre_corto }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mes">Mes:</label>
                            <input type="text" id="mes" name="mes" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="total_registros">Total de Registros:</label>
                            <input type="number" id="total_registros" name="total_registros" class="form-control" required value="{{ old('total_registros', $totalRegistros) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Calcular</button>
                    </form>
                </div>
            </div>

            <!-- Modal para mostrar los porcentajes -->
            <div class="modal fade" id="percentagesModal" tabindex="-1" role="dialog" aria-labelledby="percentagesModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="percentagesModalLabel">Porcentajes Calculados</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h3>GENERAL</h3>
                            <p>TOTALES: <span id="total_porcentaje"></span>%</p>
                            <h3>DESGLOSE</h3><br>
                            <h3>Sobre el total de registros</h3>
                            <p>SISTEMA: <span id="sistema_total_registros_porcentaje"></span>%</p>
                            <p>USUARIOS: <span id="usuarios_total_registros_porcentaje"></span>%</p>
                            <p>OTROS: <span id="otros_total_registros_porcentaje"></span>%</p>
                            <h3>Sobre el total de soportes</h3>
                            <p>DETALLE SISTEMA: <span id="sistema_total_soportes_porcentaje"></span>%</p>
                            <p>DETALLE USUARIO: <span id="usuarios_total_soportes_porcentaje"></span>%</p>
                            <p>DETALLE OTROS: <span id="otros_total_soportes_porcentaje"></span>%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch("{{ route('incidence.detail') }}")
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('incidencesTableBody');
                    tableBody.innerHTML = '';
                    data.data.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.año}</td>
                                <td>${item.mes}</td>
                                <td>${item.empresa}</td>
                                <td>${item.soportes}</td>
                                <td>${item.total_soportes}</td>
                                <td>${item.total_tiempo}</td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });
                });

            document.getElementById('calculatePercentagesForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const empresaId = document.getElementById('empresa_id').value;
                const mes = document.getElementById('mes').value;
                const totalRegistros = document.getElementById('total_registros').value;

                fetch("{{ route('incidence.calculate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        empresa_id: empresaId,
                        mes: mes,
                        total_registros: totalRegistros
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total_porcentaje').innerText = data.porcentajes.totales.toFixed(2);
                    document.getElementById('sistema_total_registros_porcentaje').innerText = data.porcentajes.sistema_total_registros.toFixed(2);
                    document.getElementById('usuarios_total_registros_porcentaje').innerText = data.porcentajes.usuarios_total_registros.toFixed(2);
                    document.getElementById('otros_total_registros_porcentaje').innerText = data.porcentajes.otros_total_registros.toFixed(2);
                    document.getElementById('sistema_total_soportes_porcentaje').innerText = data.porcentajes.sistema_total_soportes.toFixed(2);
                    document.getElementById('usuarios_total_soportes_porcentaje').innerText = data.porcentajes.usuarios_total_soportes.toFixed(2);
                    document.getElementById('otros_total_soportes_porcentaje').innerText = data.porcentajes.otros_total_soportes.toFixed(2);

                    $('#percentagesModal').modal('show');
                });
            });
        });
    </script>
@stop
