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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 200);
            $table->string('modelo', 50);
            $table->string('nro_serie', 50);
            $table->string('observaciones', 200);
            $table->string('direccion_ip', 50);
            $table->date('anio_fabricacion');
            $table->string('estado', 45);
            $table->string('imagen')->nullable();
            $table->date('fecha_instalacion');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('modalidades_id')->constrained('modalidades')->onDelete('cascade');
            $table->foreignId('local_id')->constrained('locals')->onDelete('cascade');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('cascade'); // Relación con Departamento
            $table->foreignId('subdepartamento_id')->nullable()->constrained('subdepartamentos')->onDelete('cascade'); // Relación con Sub-departamento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
};
