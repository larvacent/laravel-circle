<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Circle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Larva\User\Traits\BelongsToUserTrait;

/**
 * 圈子内成员
 * @property int $id
 * @property int $circle_id
 * @property int $user_id
 * @property int $post_count
 * @property int $reply_count
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $active_at
 *
 * @property Circle $circle
 * @property Post[] $posts
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Member extends Model
{
    use BelongsToUserTrait;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'circle_members';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'circle_id', 'user_id', 'post_count', 'reply_count', 'active_at'
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
     * 通过ID获取内容
     * @param int $id
     * @return Member|null
     */
    public static function findById($id)
    {
        return Cache::store('file')->rememberForever('circle:members:' . $id, function () use ($id) {
            return static::find($id);
        });
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
     * 获取帖子关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}