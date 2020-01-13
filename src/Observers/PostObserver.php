<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Observers;


use Larva\Circle\Models\Circle;
use Larva\Circle\Models\Post;

/**
 * 帖子观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PostObserver
{
    /**
     * Handle the member "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        Circle::query()->where('id',$post->circle_id)->increment('post_count');
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        Circle::query()->where('id',$post->circle_id)->decrement('post_count');
    }
}