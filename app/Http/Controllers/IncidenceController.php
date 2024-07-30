<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Empresa;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
class IncidenceController extends Controller
{
    public function index()
    {
        $empresas = Empresa::select('id', 'nombre_corto')->get();

        // Obtener el último valor ingresado o inicializar a 0 si no existe
        $totalRegistrosSetting = Setting::where('key', 'total_registros')->first();
        $totalRegistros = $totalRegistrosSetting ? $totalRegistrosSetting->value : 0;

        return view('incidences_report', compact('empresas', 'totalRegistros'));
    }

    public function getIncidencesData()
    {
        $incidences = Ticket::select(
                'año',
                'mes',
                'empresa_id',
                DB::raw('MIN(clave) as primera_clave'),
                DB::raw('MAX(clave) as ultima_clave'),
                DB::raw('COUNT(*) as total_soportes'),
                DB::raw('SUM(tiempo) as total_tiempo')
            )
            ->with('empresa:nombre_corto,id') // Only select the 'nombre_corto' and 'id'
            ->groupBy('año', 'mes', 'empresa_id')
            ->orderBy('año')
            ->orderByRaw('FIELD(mes, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")')
            ->get()
            ->map(function($item) {
                return [
                    'año' => $item->año,
                    'mes' => $item->mes,
                    'empresa' => $item->empresa->nombre_corto,
                    'soportes' => "Del {$item->primera_clave} al {$item->ultima_clave}",
                    'total_soportes' => $item->total_soportes,
                    'total_tiempo' => $item->total_tiempo
                ];
            });

        return response()->json(['data' => $incidences]);
    }

    public function calculatePercentages(Request $request)
    {
        $empresaId = $request->input('empresa_id');
        $mes = $request->input('mes');
        $totalRegistros = $request->input('total_registros');

        // Guardar el valor actual en la base de datos
        Setting::updateOrCreate(
            ['key' => 'total_registros'],
            ['value' => $totalRegistros]
        );

        $totalSoportes = Ticket::where('empresa_id', $empresaId)
            ->where('mes', $mes)
            ->count();

        $totalSoportesSistema = Ticket::where('empresa_id', $empresaId)
            ->where('mes', $mes)
            ->where('tipo_incidencia', 'Sistema')
            ->count();

        $totalSoportesUsuario = Ticket::where('empresa_id', $empresaId)
            ->where('mes', $mes)
            ->where('tipo_incidencia', 'Usuario')
            ->count();

        $totalSoportesOtros = Ticket::where('empresa_id', $empresaId)
            ->where('mes', $mes)
            ->where('tipo_incidencia', 'Otros')
            ->count();

        $porcentajes = [
            'totales' => ($totalSoportes / $totalRegistros) * 100,
            'sistema_total_registros' => ($totalSoportesSistema / $totalRegistros) * 100,
            'usuarios_total_registros' => ($totalSoportesUsuario / $totalRegistros) * 100,
            'otros_total_registros' => ($totalSoportesOtros / $totalRegistros) * 100,
            'sistema_total_soportes' => ($totalSoportesSistema / $totalSoportes) * 100,
            'usuarios_total_soportes' => ($totalSoportesUsuario / $totalSoportes) * 100,
            'otros_total_soportes' => ($totalSoportesOtros / $totalSoportes) * 100,
        ];

        return response()->json(['porcentajes' => $porcentajes]);
    }
}
