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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_alumno_asistencia');
            $table->unsignedBigInteger('id_profe_asistencia');
            $table->unsignedBigInteger('id_horarioasignatura_asistencia');
            $table->unsignedBigInteger('id_tipo_asistencia');

            $table->foreign('id_alumno_asistencia')->references('id')->on('alumnos');
            $table->foreign('id_profe_asistencia')->references('id')->on('profesores');
            $table->foreign('id_horarioasignatura_asistencia')->references('id')->on('horario_asignaturas');
            $table->foreign('id_tipo_asistencia')->references('id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
