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
chown -R www-data:www-data database
```

`config/app.php`

- タイムゾーンを変更: 'timezone' => 'UTC' -> 'timezone' => 'Asia/Tokyo',
- ロケール変更: 'locale' => 'en' -> 'locale' => 'ja',

## ログイン (auth) 追加、加工

- [Laravelでログイン機能を実装する](https://qiita.com/ucan-lab/items/bd0d6f6449602072cb87)
- [Laravel入門 #7 ログイン機能とカスタマイズ方法](https://knowledge.cpi.ad.jp/howto-cpi/laravel-l)

```bash: DB migrate time error No.1

 SQLSTATE[HY000]: General error: 1 Cannot add a NOT NULL column with default value NULL (SQL: alter table "users" add column "fullname" varchar not null)

 > database/migrations/???_update_user_table.php
 >（修正前） $table->string('fullname');
 >（修正後） $table->string('fullname')->default('empty name');
 ```

```bash: DB migrate time error No.2

 SQLSTATE[HY000]: General error: 1 duplicate column name: fullname (SQL: alter table "users" add column "fullname" varchar not null default 'empty name')

 > database/migrations/???_update_user_table.php
 >（修正前） $table->string('fullname')->default('empty name');
 >（修正後） # $table->string('fullname')->default('empty name'); // コメントアウトして実行をパスさせる　（一回実行ずみのため）
 ```