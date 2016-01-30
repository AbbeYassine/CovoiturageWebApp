<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Post', function(Blueprint $table) {
            $table->increments('id_Post');
            $table->string('identifiant');
            $table->string('message');
            $table->tinyInteger('type');
            $table->date('date');
            $table->integer('nb_Places');
            $table->string('source',20);
            $table->string('destination',20);
            $table->integer('prix');
            $table->integer('depart');
            $table->string('telephone',100);


            $table->integer('id_Groups')->unsigned();  
            $table->foreign('id_Groups')->references('id_Groups')->on('Groups')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');

            $table->integer('id_User')->unsigned();  
            $table->foreign('id_User')->references('id_User')->on('User')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Post', function(Blueprint $table) {
            $table->dropForeign('Post_id_User_foreign');
            $table->dropForeign('Post_id_Groups_foreign');
        });
        Schema::drop('Post');
    }
}
