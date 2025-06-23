<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('nama_kategori', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
}
