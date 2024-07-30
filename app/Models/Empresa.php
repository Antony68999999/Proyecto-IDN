<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_corto', 'nombre_comercial', 'contacto', 'telefono', 'correo'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
