<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->text('komentar');
            $table->dateTime('tanggal_komentar');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('news_id');

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('news_id')->references('news_id')->on('berita')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
