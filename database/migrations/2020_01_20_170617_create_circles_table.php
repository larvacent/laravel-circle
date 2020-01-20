<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCirclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();//圈主ID
            $table->string('name', 50)->comment('圈子名称');
            $table->string('cover_path')->nullable()->comment('圈子图片');
            $table->string('introduction')->nullable()->comment('圈子描述');
            $table->boolean('recommend')->default(false)->nullable()->comment('是否推荐');
            $table->unsignedInteger('member_count')->nullable()->default(0)->comment('圈子图片');
            $table->unsignedInteger('post_count')->nullable()->default(0)->comment('圈子图片');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circles');
    }
}
