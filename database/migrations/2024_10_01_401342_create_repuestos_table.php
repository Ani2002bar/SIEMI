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
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' auto-incremental
            $table->string('codigo', 45); // Campo para 'codigo' con un máximo de 45 caracteres
            $table->string('descripcion', 200); // Campo para 'descripcion' con un máximo de 200 caracteres
            $table->string('observaciones', 200)->nullable(); // Campo para 'observaciones' con un máximo de 200 caracteres, puede ser nulo
            $table->decimal('costo', 10, 2); // Campo para 'costo', 10 dígitos en total, 2 decimales
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade'); // Relación con 'equipos'
            $table->foreignId('local_id')->constrained('locals')->onDelete('cascade'); // Relación con 'locals'
            $table->timestamps(); // Crea columnas para 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repuestos');
    }
};
