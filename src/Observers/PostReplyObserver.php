<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Observers;

use Larva\Circle\Models\Post;
use Larva\Circle\Models\PostReply;

/**
 * 帖子回复观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PostReplyObserver
{
    /**
     * Handle the member "created" event.
     *
     * @param PostReply $postReply
     * @return void
     */
    public function created(PostReply $postReply)
    {
        Post::query()->where('id',$postReply->post_id)->increment('reply_count');
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param PostReply $postReply
     * @return void
     */
    public function deleted(PostReply $postReply)
    {
        Post::query()->where('id',$postReply->post_id)->decrement('reply_count');
    }
}