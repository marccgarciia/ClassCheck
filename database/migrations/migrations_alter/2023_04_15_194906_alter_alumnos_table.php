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
        //
        $alumnos = DB::table('alumnos')->get();

        foreach ($alumnos as $alumno) {
            DB::table('alumnos')
                ->where('id', $alumno->id)
                ->update(['password' => bcrypt($alumno->password)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
