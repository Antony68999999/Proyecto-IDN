<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function index()
    {
        return view('charts.index');
    }

    public function chartData()
    {
        $tickets = Ticket::selectRaw('YEAR(fecha_solicitud) as year, MONTH(fecha_solicitud) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();


        $monthlyData = [];
        $percentageData = [];
        $totalTickets = $tickets->sum('count');

        foreach ($tickets as $ticket) {
            $monthName = Carbon::create()->month($ticket->month)->format('F');
            $monthlyData[] = ['month' => $monthName, 'count' => $ticket->count];
            $percentageData[] = ['label' => $monthName, 'value' => round(($ticket->count / $totalTickets) * 100, 2)];
        }

        return response()->json([
            'monthlyData' => $monthlyData,
            'percentageData' => $percentageData,
        ]);
    }
    public function incidences()
   {
     return view('incidences.index');
   }
   public function incidenceData()
   {
       $tickets = Ticket::selectRaw('YEAR(fecha_solicitud) as year, MONTH(fecha_solicitud) as month, tipo_incidencia, COUNT(*) as count')
           ->groupBy('year', 'month', 'tipo_incidencia')
           ->orderBy('year')
           ->orderBy('month')
           ->get();

       $incidenceData = [];
       $totalsByType = [
           'Sistema' => 0,
           'Usuario' => 0,
           'Otros' => 0,
       ];

       foreach ($tickets as $ticket) {
           $monthName = Carbon::create()->month($ticket->month)->format('F');
           $incidenceData[$monthName][$ticket->tipo_incidencia] = $ticket->count;
           $totalsByType[$ticket->tipo_incidencia] += $ticket->count;
       }

       $tableData = [];
       foreach ($incidenceData as $month => $data) {
           $tableData[] = [
               'month' => $month,
               'Sistema' => $data['Sistema'] ?? 0,
               'Usuario' => $data['Usuario'] ?? 0,
               'Otros' => $data['Otros'] ?? 0,
               'total' => ($data['Sistema'] ?? 0) + ($data['Usuario'] ?? 0) + ($data['Otros'] ?? 0),
           ];
       }

       return response()->json([
           'tableData' => $tableData,
           'totalsByType' => $totalsByType,
           'graphData' => $tableData
       ]);
   }

   public function incidencesHours()
{
    return view('incidences.hours');
}

   // Nueva función para las horas de incidencias
   public function incidenceHoursData()
   {
      $tickets = Ticket::selectRaw('YEAR(fecha_solicitud) as year, MONTH(fecha_solicitud) as month, tipo_incidencia, SUM(tiempo) as time')
        ->groupBy('year', 'month', 'tipo_incidencia')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    $hoursData = [];
    $totalsByType = [
        'SistemaTiempo' => 0,
        'UsuarioTiempo' => 0,
        'OtrosTiempo' => 0,
    ];

    foreach ($tickets as $ticket) {
        $monthName = Carbon::create()->month($ticket->month)->format('F');
        $hoursData[$ticket->year][$monthName][$ticket->tipo_incidencia . 'Tiempo'] = $ticket->time;
        $totalsByType[$ticket->tipo_incidencia . 'Tiempo'] += $ticket->time;
    }

    $tableData = [];
    foreach ($hoursData as $year => $months) {
        foreach ($months as $month => $data) {
            $tableData[] = [
                'month' => $month,
                'SistemaTiempo' => $data['SistemaTiempo'] ?? 0,
                'UsuarioTiempo' => $data['UsuarioTiempo'] ?? 0,
                'OtrosTiempo' => $data['OtrosTiempo'] ?? 0,
                'totalTiempo' => ($data['SistemaTiempo'] ?? 0) + ($data['UsuarioTiempo'] ?? 0) + ($data['OtrosTiempo'] ?? 0),
            ];
        }
    }

    return response()->json([
        'tableData' => $tableData,
        'totalsByType' => $totalsByType,
        'graphData' => $tableData
    ]);
   }
}
