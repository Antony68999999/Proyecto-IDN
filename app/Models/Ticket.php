<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'año', 'mes', 'empresa_id', 'fecha_solicitud', 'clave', 'asunto', 'estatus',
        'tipo_incidencia', 'proceso', 'observacion', 'tiempo'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $empresa = Empresa::find($ticket->empresa_id);
            $count = Ticket::where('empresa_id', $ticket->empresa_id)->count() + 1;
            $ticket->clave = strtoupper(substr($empresa->nombre_corto, 0, 3)) . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
