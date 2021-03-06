<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('nickname')->default('活动行用户');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('pic')->default('/img/个人头像图.png');
            $table->tinyInteger('is_active')->default(0);
            $table->string('signature',255)->default('我思故我在');
            $table->string('confirmation_token',40)->default('')->comment('邮件token');
            $table->string('api_token')->default('')->comment('api_token授权');
            $table->rememberToken();
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
