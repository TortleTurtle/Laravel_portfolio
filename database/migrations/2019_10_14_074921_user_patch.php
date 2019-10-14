<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add remembertoken collumn to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('remember_token', 100)->nullable($value = true);
            $table->string('password')->nullable($value = false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //delete remembertoken collumn from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remember_token');
            $table->dropColumn('password');
        });
    }
}
