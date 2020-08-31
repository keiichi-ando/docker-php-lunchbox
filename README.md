# PHP Lalabel5

Docker template

## include

- [php:apache-buster](https://hub.docker.com/layers/php/library/php/apache-buster/images/sha256-de0cf026c47735646737b393bb14a143c1aebf552f04055df0f44014b105796b?context=explore)
- [Laravel - ウェブ職人のためのPHPフレームワーク](http://laravel.jp/)

## setting

[Laravel 7.x インストール - readable.com](https://readouble.com/laravel/7.x/ja/installation.html)

フォルダのパーミッションを変更

```bash
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

`config/app.php`

- タイムゾーンを変更: 'timezone' => 'UTC' -> 'timezone' => 'Asia/Tokyo',
- ロケール変更: 'locale' => 'en' -> 'locale' => 'ja',
