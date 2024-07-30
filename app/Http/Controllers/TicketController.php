<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all(); //with('empresa')->get();
        $empresas = Empresa::all();
        return view('tickets.index', compact('tickets', 'empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'año' => 'required|integer',
            'mes' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
            'fecha_solicitud' => 'required|date',
            'asunto' => 'required|string',
            'estatus' => 'required|in:Abierto,En proceso,Cerrado',
            'tipo_incidencia' => 'required|in:Sistema,Usuario,Otros',
            'proceso' => 'nullable|string',
            'observacion' => 'nullable|string',
            'tiempo' => 'nullable|numeric',
        ]);

        Ticket::create($request->all());
        return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'año' => 'required|integer',
            'mes' => 'required|string',
            'empresa_id' => 'required|exists:empresas,id',
            'fecha_solicitud' => 'required|date',
            'asunto' => 'required|string',
            'estatus' => 'required|in:Abierto,En proceso,Cerrado',
            'tipo_incidencia' => 'required|in:Sistema,Usuario,Otros',
            'proceso' => 'nullable|string',
            'observacion' => 'nullable|string',
            'tiempo' => 'nullable|numeric',
        ]);

        $ticket->update($request->all());
        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado exitosamente.');
    }
}
