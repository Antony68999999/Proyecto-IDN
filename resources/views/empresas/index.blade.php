@extends('adminlte::page')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Empresas</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('empresas.create') }}" class="btn btn-primary">Crear Empresa</a>
                    </div>
                    <div class="card-body">
                        <table id="empresasTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>   
                                    <th>Nombre Corto</th>
                                    <th>Nombre Comercial</th>
                                    <th>Contacto Empresa</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empresas as $empresa)
                                    <tr>
                                        <td>{{ $empresa->{'nombre_corto'} }}</td>
                                        <td>{{ $empresa->{'nombre_comercial'} }}</td>
                                        <td>{{ $empresa->contacto ?? '' }} <br> {{ $empresa->telefono ?? '' }} <br> {{ $empresa->correo ?? '' }}</td>
                                        
                                        <td>
                                            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning">Editar</a>
                                            <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta empresa?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
