
<!-- resources/views/empresas/create.blade.php -->

@extends('adminlte::page')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Crear Empresa</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Nueva Empresa</h3>
                    </div>
                    <form role="form" action="{{ route('empresas.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nombre-corto">Nombre Corto</label>
                                <input type="text" class="form-control" id="nombre-corto" name="nombre-corto" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre-comercial">Nombre Comercial</label>
                                <input type="text" class="form-control" id="nombre-comercial" name="nombre-comercial" required>
                            </div>
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
