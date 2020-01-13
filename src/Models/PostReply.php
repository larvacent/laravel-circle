<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 帖子回复
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class PostReply extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'circle_post_replies';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'circle_id', 'post_id', 'user_id'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the circle that the charge belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    /**
     * Get the post that the charge belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}