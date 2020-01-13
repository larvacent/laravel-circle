<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Observers;

use Larva\Circle\Models\Circle;

/**
 * 圈子模型观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CircleObserver
{
    /**
     * Handle the circle "created" event.
     *
     * @param Circle $circle
     * @return void
     */
    public function created(Circle $circle)
    {
        \App\Models\UserExtra::query()->where('user_id', $circle->user_id)->increment('circles');
    }

    /**
     * Handle the circle "deleted" event.
     *
     * @param Circle $circle
     * @return void
     */
    public function deleted(Circle $circle)
    {
        \App\Models\UserExtra::query()->where('user_id', $circle->user_id)->decrement('circles');
    }
}