<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('role_id');
            $table->string('role_name', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
