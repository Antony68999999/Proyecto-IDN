<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('año');
            $table->string('mes');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->date('fecha_solicitud');
            $table->string('clave')->unique();
            $table->longText('asunto');
            $table->enum('estatus', ['Abierto', 'En proceso', 'Cerrado']);
            $table->enum('tipo_incidencia', ['Sistema', 'Usuario','Otros']);
            $table->string('proceso')->nullable();
            $table->text('observacion')->nullable();
            $table->decimal('tiempo', 8, 2)->nullable(); // Cambio aquí
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
