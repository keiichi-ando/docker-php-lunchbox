# PHP Lalabel5

Docker template

## include

-   [php:apache-buster](https://hub.docker.com/layers/php/library/php/apache-buster/images/sha256-de0cf026c47735646737b393bb14a143c1aebf552f04055df0f44014b105796b?context=explore)
-   [Laravel - ウェブ職人のための PHP フレームワーク](http://laravel.jp/)

## setting

[Laravel 7.x インストール - readable.com](https://readouble.com/laravel/7.x/ja/installation.html)

フォルダのパーミッションを変更

```bash
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chown -R www-data:www-data database
```

`config/app.php`

-   タイムゾーンを変更: 'timezone' => 'UTC' -> 'timezone' => 'Asia/Tokyo'
-   ロケール変更: 'locale' => 'en' -> 'locale' => 'ja'

## ログイン (auth) 追加、加工

- [Laravel でログイン機能を実装する](https://qiita.com/ucan-lab/items/bd0d6f6449602072cb87)
- [Laravel 入門 #7 ログイン機能とカスタマイズ方法](https://knowledge.cpi.ad.jp/howto-cpi/laravel-l)

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

## Vue

laravel-mix

- [Laravel7 から Vue.js を使う最短レシピ - Qiita](https://qiita.com/fruitriin/items/118c773b045101db7651)
- 未 [Laravel 6 API と Vue.js で SPA 構築 最速入門](https://noumenon-th.net/programming/2020/02/13/laravel-vue-spa/)
- 未 [laravel で vue.js , axios を使う](https://qiita.com/ma7ma7pipipi/items/d58b1a8114f122bf918d)
- 未 [Vue-cropper.js で画像トリミング機能実装](https://www.koatech.info/blog/vue-cropper-js-intro/)
- 未 [vue-cropper で画像のトリミングをする - だいそんブログ](https://dkdk0125.work/vue-cropper%E3%81%A7%E7%94%BB%E5%83%8F%E3%81%AE%E3%83%88%E3%83%AA%E3%83%9F%E3%83%B3%E3%82%B0%E3%82%92%E3%81%99%E3%82%8B/)
- 未 [Vue + axios でLaravelにユーザー認証する（ダウンロード可）- CONSOLE DOT LOG](https://blog.capilano-fw.com/?p=3458)

- 未[【Laravel 6 & PHP 7.4 対応】Vue + Vue Router + Vuex + Laravel チュートリアル（全16回）を書きました。- Qiita](https://qiita.com/MasahiroHarada/items/2597bd6973a45f92e1e8)

## Laravel Mix

webのルートフォルダを public から変更する

```bootstrap/app.php
// 追加 (ex. change to public_html)
$app->bind('path.public', function () {
    return base_path("public_html");
});
```

参考[Laravel5.7メモ：publicをpublic_htmlにリネームしたい - note](https://note.com/watarunakayama/n/n16efb005ef6e)

## DB

[Laravel のマイグレーションで、テーブルを新規作成する - YoheiM.NET](https://www.yoheim.net/blog.php?q=20180506)

## api

-　カレンダー４週分配列追加 [2020年9月6日から2020年9月12日まで](http://www.jpn.week-numbers.com/37%E5%B9%B4%E7%AC%AC2020%E9%80%B1.html)
