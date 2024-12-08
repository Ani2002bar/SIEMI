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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' auto-incremental
            $table->string('nombre', 50); // Campo para nombre con un máximo de 20 caracteres
            $table->string('apellido', 50); // Campo para apellido con un máximo de 20 caracteres
            $table->string('correo', 200); // Campo para correo con un máximo de 200 caracteres
            $table->string('telefono', 20); // Campo para teléfono con un máximo de 20 caracteres
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('tecnicos');
    }
};
