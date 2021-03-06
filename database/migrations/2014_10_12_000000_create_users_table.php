<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->rememberToken();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->default('backend/images/users/profile/user_default.jpg');
            $table->string('cover_image')->default('backend/images/users/cover/cover_default.jpg');
            $table->string('birth_day')->nullable();
            $table->string('gender')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('fb_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
