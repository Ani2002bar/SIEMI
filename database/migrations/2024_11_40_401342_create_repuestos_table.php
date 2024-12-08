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
            $table->id(); // ID del repuesto
            $table->string('nro_parte', 50)->nullable(); // Número de parte
            $table->string('nro_serie', 50)->nullable(); // Número de serie
            $table->string('descripcion', 200); // Descripción
            $table->string('observaciones', 200)->nullable(); // Observaciones opcionales
            $table->decimal('costo', 10, 2)->nullable(); // Costo opcional
            $table->enum('estado', ['Instalado', 'No Instalado'])->default('No Instalado'); // Campo estado
            // Relaciones opcionales
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();
            $table->foreignId('local_id')->nullable()->constrained('locals')->nullOnDelete();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->nullOnDelete();
            $table->foreignId('subcomponente_id')->nullable()->constrained('subcomponentes')->nullOnDelete();
            $table->foreignId('componente_id')->nullable()->constrained('componentes')->nullOnDelete();

            $table->timestamps(); // Fechas de creación y actualización
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
