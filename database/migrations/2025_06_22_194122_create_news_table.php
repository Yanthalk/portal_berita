<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('news_id');
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->dateTime('tanggal_publish');
            $table->longText('konten');
            $table->string('gambar');
            $table->string('penulis');
            $table->unsignedInteger('category_id');
            
            $table->foreign('category_id')->references('category_id')->on('category')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
}
