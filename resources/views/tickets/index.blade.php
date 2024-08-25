@extends('adminlte::page')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tickets</h1>
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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createTicketModal">Crear Ticket</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Empresa</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Clave</th>
                                    <th>Asunto</th>
                                    <th>Estatus</th>
                                    <th>Tipo Incidencia</th>
                                    <th>Proceso</th>
                                    <th>Observación</th>
                                    <th>Tiempo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->año }}</td>
                                        <td>{{ $ticket->mes }}</td>
                                        <td>{{ $ticket->empresa->nombre_corto }}</td>
                                        <td style="white-space: nowrap;">{{ $ticket->fecha_solicitud }}</td>
                                        <td style="white-space: nowrap;">{{ $ticket->clave }}</td>
                                        <td>{{ $ticket->asunto }}</td>
                                        <td>{{ $ticket->estatus }}</td>
                                        <td>{{ $ticket->tipo_incidencia }}</td>
                                        <td>{{ $ticket->proceso }}</td>
                                        <td>{{ $ticket->observacion }}</td>
                                        <td>{{ $ticket->tiempo }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editTicketModal-{{ $ticket->id }}"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este ticket?')"> <i class="fas fa-trash-alt"></i></button>
                                            </form>
                                            <button class="btn btn-info" data-toggle="modal" data-target="#viewTicketModal-{{ $ticket->id }}"><i class="fas fa-eye"></i></button>
                                           </div>
                                        </td>
                                   
                                    </tr>
                                    


                                    <!-- Edit Ticket Modal -->
                                    <div class="modal fade" id="editTicketModal-{{ $ticket->id }}" tabindex="-1" role="dialog" aria-labelledby="editTicketModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTicketModalLabel">Editar Ticket</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="año">Año</label>
                                                            <input type="text" class="form-control" name="año" value="{{ $ticket->año }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="mes">Mes</label>
                                                            <input type="text" class="form-control" name="mes" value="{{ $ticket->mes }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="empresa_id">Empresa</label>
                                                            <select class="form-control" name="empresa_id" required>
                                                                @foreach($empresas as $empresa)
                                                                    <option value="{{ $empresa->id }}" {{ $empresa->id == $ticket->empresa_id ? 'selected' : '' }}>{{ $empresa->nombre_corto }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha_solicitud">Fecha de Solicitud</label>
                                                            <input type="date" class="form-control" name="fecha_solicitud" value="{{ $ticket->fecha_solicitud }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="asunto">Asunto</label>
                                                            <input type="text" class="form-control" name="asunto" value="{{ $ticket->asunto }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="estatus">Estatus</label>
                                                            <select class="form-control" name="estatus" required>
                                                                <option value="Abierto" {{ $ticket->estatus == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                                                <option value="En proceso" {{ $ticket->estatus == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                                                                <option value="Cerrado" {{ $ticket->estatus == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tipo_incidencia">Tipo de Incidencia</label>
                                                            <select class="form-control" name="tipo_incidencia" required>
                                                                <option value="Sistema" {{ $ticket->tipo_incidencia == 'Sistema' ? 'selected' : '' }}>Sistema</option>
                                                                <option value="Usuario" {{ $ticket->tipo_incidencia == 'Usuario' ? 'selected' : '' }}>Usuario</option>
                                                                <option value="Otros" {{ $ticket->tipo_incidencia == 'Otros' ? 'selected' : '' }}>Otros</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="proceso">Proceso</label>
                                                            <input type="text" class="form-control" name="proceso" value="{{ $ticket->proceso }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="observacion">Observación</label>
                                                            <input type="text" class="form-control" name="observacion" value="{{ $ticket->observacion }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tiempo">Tiempo</label>
                                                            <input type="text" class="form-control" name="tiempo" value="{{ $ticket->tiempo }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- View Ticket Modal -->
<div class="modal fade" id="viewTicketModal-{{ $ticket->id }}" tabindex="-1" role="dialog" aria-labelledby="viewTicketModalLabel-{{ $ticket->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTicketModalLabel-{{ $ticket->id }}">Detalles del Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ticket-details">
                    <p><strong>Año:</strong> {{ $ticket->año }}</p>
                    <p><strong>Mes:</strong> {{ $ticket->mes }}</p>
                    <p><strong>Empresa:</strong> {{ $ticket->empresa->nombre_corto }}</p>
                    <p><strong>Fecha Solicitud:</strong> {{ $ticket->fecha_solicitud }}</p>
                    <p><strong>Clave:</strong> {{ $ticket->clave }}</p>
                    <p><strong>Asunto:</strong> {{ $ticket->asunto }}</p>
                    <p><strong>Estatus:</strong> {{ $ticket->estatus }}</p>
                    <p><strong>Tipo Incidencia:</strong> {{ $ticket->tipo_incidencia }}</p>
                    <p><strong>Proceso:</strong> {{ $ticket->proceso }}</p>
                    <p><strong>Observación:</strong> {{ $ticket->observacion }}</p>
                    <p><strong>Tiempo:</strong> {{ $ticket->tiempo }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Ticket Modal -->
<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="createTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTicketModalLabel">Crear Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="año">Año</label>
                        <input type="text" class="form-control" name="año" required>
                    </div>
                    <div class="form-group">
                        <label for="mes">Mes</label>
                        <input type="text" class="form-control" name="mes" required>
                    </div>
                    <div class="form-group">
                        <label for="empresa_id">Empresa</label>
                        <select class="form-control" name="empresa_id" required>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->nombre_corto }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_solicitud">Fecha de Solicitud</label>
                        <input type="date" class="form-control" name="fecha_solicitud" required>
                    </div>
                    <div class="form-group">
                        <label for="asunto">Asunto</label>
                        <input type="text" class="form-control" name="asunto" required>
                    </div>
                    <div class="form-group">
                        <label for="estatus">Estatus</label>
                        <select class="form-control" name="estatus" required>
                            <option value="Abierto">Abierto</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Cerrado">Cerrado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_incidencia">Tipo de Incidencia</label>
                        <select class="form-control" name="tipo_incidencia" required>
                            <option value="Sistema">Sistema</option>
                            <option value="Usuario">Usuario</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="proceso">Proceso</label>
                        <input type="text" class="form-control" name="proceso">
                    </div>
                    <div class="form-group">
                        <label for="observacion">Observación</label>
                        <input type="text" class="form-control" name="observacion">
                    </div>
                    <div class="form-group">
                        <label for="tiempo">Tiempo</label>
                        <input type="text" class="form-control" name="tiempo">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Ticket</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection