<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCirclePostRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_post_replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('circle_id')->comment('圈子ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->unsignedBigInteger('post_id')->comment('帖子ID');
            $table->text('content')->comment('内容');

            $table->timestamps();
            $table->foreign('circle_id')->references('id')->on('circles');
            $table->foreign('post_id')->references('id')->on('circle_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circle_post_replies');
    }
}
