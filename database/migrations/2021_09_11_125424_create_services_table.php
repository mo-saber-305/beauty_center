<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration
{

    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->boolean('as_offers')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('services');
    }
}
