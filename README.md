# laravel-circle

Laravel 圈子，类似百度贴吧或者迅雷电影圈子

## 环境需求

- PHP >= 7.1.3

## Installation

```bash
composer require larva/laravel-circle -vv
```

## for Laravel

This service provider must be registered.

```php
// config/app.php

'providers' => [
    '...',
    Larva\Circle\CircleServiceProvider::class,
];
```
## 数据表
```php
Schema::table('users', function (Blueprint $table) {
    $table->unsignedInteger('circles')->default(0)->nullable()->after('balance');
});
```




