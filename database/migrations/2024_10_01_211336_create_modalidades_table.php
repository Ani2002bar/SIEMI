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
        Schema::create('modalidades', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' auto-incremental
            $table->string('nombre', 50); // Campo para nombre con un máximo de 45 caracteres
            $table->string('descripcion', 200); // Campo para descripción con un máximo de 200 caracteres
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
        Schema::dropIfExists('modalidades');
    }
};
