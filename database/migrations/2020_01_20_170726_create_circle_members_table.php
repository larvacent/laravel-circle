<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCircleMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circle_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('circle_id')->comment('圈子ID');
            $table->unsignedBigInteger('user_id')->comment('用户ID');
            $table->unsignedInteger('post_count')->nullable()->default(0)->comment('帖子数量');
            $table->unsignedInteger('reply_count')->nullable()->default(0)->comment('回帖数量');
            $table->timestamp('active_at')->nullable()->comment('最后活动时间');
            $table->timestamps();

            $table->unique(['circle_id', 'user_id']);
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
        Schema::dropIfExists('circle_members');
    }
}
