<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('category_id')->unsigned();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('image')->default('backend/images/sub_categories/default.jpg');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('sub_categories');
    }
}
