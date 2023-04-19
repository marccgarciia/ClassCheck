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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            #Lo ponemos en string ya que será algo rollo 22-23.
            $table->string('promocion');
            // $table->unsignedBigInteger('id_profesor');
            $table->unsignedBigInteger('id_escuela');

            // $table->foreign('id_profesor')->references('id')->on('profesores');
            // $table->foreign('id_escuela')->references('id')->on('escuelas');
            $table->foreign('id_escuela')->references('id')->on('escuelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
