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
        Schema::create('subcomponentes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->string('modelo', 100)->nullable();
            $table->string('nro_serie', 100)->nullable();
            $table->foreignId('componente_id')->constrained('componentes')->onDelete('cascade'); // Relación con Componente
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
        Schema::dropIfExists('subcomponentes');
    }
};
