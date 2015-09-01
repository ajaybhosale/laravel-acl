<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 30);
            $table->string('slug', 30)->unique();
            $table->tinyInteger('status')->default(1);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl_roles');
    }

}
