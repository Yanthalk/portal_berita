<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('nama', 100);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->unsignedInteger('role_id');
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('roles')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
