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
    Schema::create('asignaturas', function (Blueprint $table) {
        $table->id();
        $table->string("nombre");
        $table->unsignedBigInteger('id_curso');
        $table->unsignedBigInteger('id_profesor');
        $table->date('fecha_inicio');
        $table->date('fecha_fin');

        $table->foreign('id_profesor')->references('id')->on('profesores')->onDelete('cascade');
        $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};