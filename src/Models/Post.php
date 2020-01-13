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

/**
 * 圈子内帖子
 * @property int $id
 * @property int $user_id
 * @property int $circle_id
 * @property boolean $recommend 推荐
 * @property int $views 查看数
 * @property int $reply_count 回复数
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $replied_at
 *
 * @property Circle $circle
 * @property PostReply[] $postReplies
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Post recommend()
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
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'views' => 0,
        'reply_count' => 0,
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

    /**
     * 查询推荐的
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecommend($query)
    {
        return $query->where('recommend', '=', true);
    }

    /**
     * 获取推荐帖子
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function recommended($limit = 10)
    {
        $ids = Cache::store('file')->remember('circle:posts:recommended:ids', now()->addMinutes(60), function () use ($limit) {
            return static::recommend()->orderByDesc('id')->orderByDesc('created_at')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 通过ID获取内容
     * @param int $id
     * @return Post|null
     */
    public static function findById($id)
    {
        return Cache::store('file')->rememberForever('circle:posts:' . $id, function () use ($id) {
            return static::find($id);
        });
    }
}