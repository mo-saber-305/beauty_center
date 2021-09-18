<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('section_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('image')->default('backend/images/categories/default.jpg');
            $table->text('description_ar');
            $table->text('description_en');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }
}
