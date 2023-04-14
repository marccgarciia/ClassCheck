<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horario_asignaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_asignatura_int');
            $table->unsignedBigInteger('id_horario_int');

            $table->foreign('id_asignatura_int')->references('id')->on('asignaturas');
            $table->foreign('id_horario_int')->references('id')->on('horarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_asignaturas');
    }
};
