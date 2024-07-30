@extends('adminlte::page')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar Empresa</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nombre-corto">Nombre Corto</label>
                                <input type="text" class="form-control" id="nombre-corto" name="nombre-corto" value="{{ $empresa->{'nombre-corto'} }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre-comercial">Nombre Comercial</label>
                                <input type="text" class="form-control" id="nombre-comercial" name="nombre-comercial" value="{{ $empresa->{'nombre-comercial'} }}" required>
                            </div>
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto" value="{{ $empresa->contacto }}">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $empresa->telefono }}">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="{{ $empresa->correo }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
