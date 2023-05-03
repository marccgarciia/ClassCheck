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
        $admins = DB::table('admins')->get();
    
        foreach ($admins as $admin) {
            DB::table('admins')
                ->where('id', $admin->id)
                ->update(['password' => bcrypt($admin->password)]);
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
