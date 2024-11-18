<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->decimal('costo_reparacion', 10, 2); // Costo del mantenimiento
            $table->string('estado', 100); // Estado del mantenimiento
            $table->date('fecha'); // Fecha del mantenimiento
            $table->string('observaciones', 200)->nullable(); // Observaciones adicionales
            
            // Relaciones
            $table->foreignId('tecnico_id')->constrained('tecnicos')->onDelete('cascade'); // Técnico responsable
            $table->foreignId('local_id')->constrained('locals')->onDelete('cascade'); // Local donde se realiza el mantenimiento
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade'); // Equipo involucrado
            $table->foreignId('repuesto_id')->nullable()->constrained('repuestos')->onDelete('cascade'); // Repuestos utilizados
            $table->foreignId('componente_id')->nullable()->constrained('componentes')->onDelete('cascade'); // Componentes utilizados
            $table->foreignId('subcomponente_id')->nullable()->constrained('subcomponentes')->onDelete('cascade'); // Subcomponentes utilizados

            $table->timestamps(); // Marcas de tiempo
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mantenimientos');
    }
};
