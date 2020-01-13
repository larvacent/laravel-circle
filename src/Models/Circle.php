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
 * 圈子
 * @property int $id
 * @property int $user_id
 * @property string $user
 * @property string $cover_path
 * @property string $introduction
 * @property int $member_count
 * @property int $post_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Circle recommend()
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Circle extends Model
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'circles';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'cover_path', 'introduction', 'recommend', 'member_count', 'post_count'
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
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $attributes = [
        'member_count' => 0,
        'post_count' => 0,
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
     * 圈内帖子关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 圈内成员关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
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
     * 通过ID获取内容
     * @param int $id
     * @return Circle|null
     */
    public static function findById($id)
    {
        return Cache::store('file')->rememberForever('circles:' . $id, function () use ($id) {
            return static::find($id);
        });
    }

    /**
     * 获取推荐帖子
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function recommended($limit = 10)
    {
        $ids = Cache::store('file')->remember('circles:recommended:ids', now()->addMinutes(60), function () use ($limit) {
            return static::recommend()->orderByDesc('id')->orderByDesc('created_at')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }

    /**
     * 获取活跃会员
     * @param int $limit
     * @return mixed
     */
    public function activeMembers($limit = 5)
    {
        $ids = Cache::store('file')->remember('circles:activeMembers:ids', now()->addMinutes(15), function () use ($limit) {
            return static::members()->orderByDesc('active_at')->limit($limit)->pluck('id');
        });
        return $ids->map(function ($id) {
            return static::findById($id);
        });
    }
}