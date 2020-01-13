<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */
namespace Larva\Circle;

use Illuminate\Support\ServiceProvider;

/**
 * 圈子服务提供者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CircleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'circle-migrations');

            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/circle'),
            ], 'circle-lang');
        }

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'circle');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'circle');

        // Observers
        \Larva\Circle\Models\Circle::observe(\Larva\Circle\Observers\CircleObserver::class);
        \Larva\Circle\Models\Member::observe(\Larva\Circle\Observers\MemberObserver::class);
        \Larva\Circle\Models\Post::observe(\Larva\Circle\Observers\PostObserver::class);
        \Larva\Circle\Models\PostReply::observe(\Larva\Circle\Observers\PostReplyObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}