<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCirclePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('circle_id')->comment('圈子ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');

            $table->boolean('recommend')->comment('是否推荐');
            $table->string('title')->comment('标题');
            $table->text('content')->comment('内容');

            $table->unsignedInteger('views')->nullable()->default(0)->comment('查看数量');
            $table->unsignedInteger('reply_count')->nullable()->default(0)->comment('回帖数量');
            $table->timestamp('replied_at')->nullable()->comment('最后回复时间');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circle_posts');
    }
}
