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
            $table->string('marca', 50);
            $table->string('observaciones', 200)->nullable();
            $table->string('direccion_ip', 50)->nullable();
            $table->date('anio_fabricacion')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->string('imagen')->nullable();
            $table->date('fecha_instalacion')->nullable();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->onDelete('cascade');
            $table->foreignId('modalidades_id')->nullable()->constrained('modalidades')->onDelete('cascade');
            $table->foreignId('local_id')->constrained('locals')->onDelete('cascade');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('subdepartamento_id')->nullable()->constrained('subdepartamentos')->onDelete('cascade');
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
