<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mantenimiento_repuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantenimiento_id')->constrained()->onDelete('cascade');
            $table->foreignId('repuesto_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad')->default(1); // Cantidad de repuestos usados
            $table->decimal('costo_total', 10, 2);  // Costo total por repuesto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_repuesto');
    }
};

