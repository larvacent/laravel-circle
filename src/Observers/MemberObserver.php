<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Observers;


use Larva\Circle\Models\Circle;
use Larva\Circle\Models\Member;

/**
 * 圈子成员观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class MemberObserver
{
    /**
     * Handle the member "created" event.
     *
     * @param Member $member
     * @return void
     */
    public function created(Member $member)
    {
        Circle::query()->where('id',$member->circle_id)->increment('member_count');
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param Member $member
     * @return void
     */
    public function deleted(Member $member)
    {
        Circle::query()->where('id',$member->circle_id)->decrement('member_count');
    }
}