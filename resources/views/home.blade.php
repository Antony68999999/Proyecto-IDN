@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="text-center">Bienvenido a la Plataforma de Tickets de Soporte</h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="jumbotron text-center bg-info text-white">
            <h1 class="display-4">¡Hola!</h1>
            <p class="lead">Gestiona y resuelve tus tickets de manera eficiente.</p>
            <hr class="my-4">
            <p>Utiliza las opciones del menú lateral para navegar por las distintas funcionalidades de la plataforma.</p>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header bg-primary text-white">Registro de Empresas</div>
                    <div class="card-body">
                        <p class="card-text">Añade y gestiona las empresas registradas en la plataforma.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header bg-warning text-white">Tickets</div>
                    <div class="card-body">
                        <p class="card-text">Crea, visualiza y administra los tickets de soporte.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header bg-success text-white">Reportes</div>
                    <div class="card-body">
                        <p class="card-text">Genera y consulta reportes detallados de soporte.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-light mb-3">
                    <div class="card-header bg-danger text-white">Estadísticas</div>
                    <div class="card-body">
                        <p class="card-text">Visualiza estadísticas y gráficas de desempeño.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .jumbotron {
            background-color: #17a2b8;
            color: white;
        }
        .card-header {
            font-size: 1.25rem;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
