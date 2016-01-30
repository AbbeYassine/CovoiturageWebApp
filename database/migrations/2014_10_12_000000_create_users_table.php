<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('id_User');
            $table->string('identifiant',100);
            $table->string('nom',100);
            $table->string('prenom',100);
            $table->string('telephone',12);
            $table->string('link',100);
            $table->tinyInteger('active');
            $table->string('login');
            $table->string('password',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
