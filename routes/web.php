<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\IncidenceController;


// En tu archivo de rutas (por ejemplo, routes/web.php)
Route::get('/home', function () {
    // Tu lógica para mostrar el dashboard
})->middleware('auth'); // Aplica el middleware de autenticación a esta ruta

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home'); // Cambia '/home' por la ruta de tu dashboard
    } else {
        return view('welcome');
    }
});

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::auth();

Route::middleware(['auth', 'no.cache'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('empresas', EmpresaController::class);
    Route::resource('tickets', TicketController::class);
    Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
    Route::get('/chart-data', [ChartController::class, 'chartData'])->name('charts.data');
    Route::get('/incidences', [ChartController::class, 'incidences'])->name('incidences.index');
    Route::get('/incidences/data', [ChartController::class, 'incidenceData'])->name('incidence.data');
    Route::get('/incidences/hours', [ChartController::class, 'incidencesHours'])->name('incidences.hours');
    Route::get('/incidence-hours-data', [ChartController::class, 'incidenceHoursData'])->name('incidence.hours.data');
    
    
    Route::get('/incidences-report', [IncidenceController::class, 'index'])->name('incidence.report');
    Route::get('/incidences-report/detail', [IncidenceController::class, 'getIncidencesData'])->name('incidence.detail');
    Route::post('/incidences/calculate', [IncidenceController::class, 'calculatePercentages'])->name('incidence.calculate');
    // Agrega aquí otras rutas protegidas
});

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('empresas', EmpresaController::class);
Route::resource('tickets', TicketController::class);
Route::get('/charts', [ChartController::class, 'index'])->name('charts.index');
Route::get('/chart-data', [ChartController::class, 'chartData'])->name('charts.data');
Route::get('/incidences', [ChartController::class, 'incidences'])->name('incidences.index');
Route::get('/incidences/data', [ChartController::class, 'incidenceData'])->name('incidence.data');
Route::get('/incidences/hours', [ChartController::class, 'incidencesHours'])->name('incidences.hours');
Route::get('/incidence-hours-data', [ChartController::class, 'incidenceHoursData'])->name('incidence.hours.data');


Route::get('/incidences-report', [IncidenceController::class, 'index'])->name('incidence.report');
Route::get('/incidences-report/detail', [IncidenceController::class, 'getIncidencesData'])->name('incidence.detail');
Route::post('/incidences/calculate', [IncidenceController::class, 'calculatePercentages'])->name('incidence.calculate');*/