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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('direccion', 200);
            $table->string('direccion_ip', 45);
            $table->string('telefono', 20)->nullable(); // Campo para el número de teléfono
            $table->string('imagen')->nullable(); // Campo para almacenar la URL o ruta de la imagen
            $table->foreignId('local_id')->constrained('locals')->onDelete('cascade');
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
        Schema::dropIfExists('empresas');
    }
};
