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
 * 圈子内帖子
 * @property int $id
 * @property int $user_id
 * @property int $circle_id
 * @property boolean $recommend
 * @property int $views 查看数
 * @property int $reply_count 回复数
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Post extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'circle_posts';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'circle_id', 'user_id', 'recommend', 'views', 'reply_count', 'replied_at'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'replied_at'
    ];

    /**
     * Get the user that the charge belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(
            config('auth.providers.' . config('auth.guards.api.provider') . '.model')
        );
    }

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
     * 帖子回复关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(PostReply::class);
    }
}