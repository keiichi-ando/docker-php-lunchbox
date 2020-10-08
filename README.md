# PHP Lalabel5

Docker template

## include

- [php:apache-buster](https://hub.docker.com/layers/php/library/php/apache-buster/images/sha256-de0cf026c47735646737b393bb14a143c1aebf552f04055df0f44014b105796b?context=explore)
- [Laravel - ウェブ職人のための PHP フレームワーク](http://laravel.jp/)

## setting

[Laravel 7.x インストール - readable.com](https://readouble.com/laravel/7.x/ja/installation.html)

フォルダのパーミッションを変更

```bash
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chown -R www-data:www-data database
```

`config/app.php`

- タイムゾーンを変更: 'timezone' => 'UTC' -> 'timezone' => 'Asia/Tokyo'
- ロケール変更: 'locale' => 'en' -> 'locale' => 'ja'

### git clone

docker を起動後

```bash
composer update
npm install
vi .env
php artisan key:generate
php artisan migrate --seed # for develop only
```

## ログイン (auth) 追加、加工

- [Laravel でログイン機能を実装する](https://qiita.com/ucan-lab/items/bd0d6f6449602072cb87)
- [Laravel 入門 #7 ログイン機能とカスタマイズ方法](https://knowledge.cpi.ad.jp/howto-cpi/laravel-login/)
- [Laravel（API）で Cookie を使ったセッション管理を有効にする](https://deha.co.jp/magazine/admin-laravel-nuxt-cookie-auth/#Cookie)
- [Laravel でユーザー認証されている時のユーザー情報の値のとり方や、判定する関数など - memocarilog](https://memocarilog.info/php-mysql/8749)

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
- 未 [Vue + axios で Laravel にユーザー認証する（ダウンロード可）- CONSOLE DOT LOG](https://blog.capilano-fw.com/?p=3458)

- 未[【Laravel 6 & PHP 7.4 対応】Vue + Vue Router + Vuex + Laravel チュートリアル（全 16 回）を書きました。- Qiita](https://qiita.com/MasahiroHarada/items/2597bd6973a45f92e1e8)

## Laravel Mix

web のルートフォルダを public から変更する

```bootstrap/app.php
$app->bind('path.public', function () { // 追加 (ex. change to public_html)
    return base_path("public_html");
});
```

js,css の出力先も変える場合は

```webpack.mix.js
mix.setPublicPath('public_html/'); // 追加
```

参考[Laravel5.7 メモ：public を public_html にリネームしたい - note](https://note.com/watarunakayama/n/n16efb005ef6e)

## DB

[Laravel のマイグレーションで、テーブルを新規作成する - YoheiM.NET](https://www.yoheim.net/blog.php?q=20180506)

## api

-　カレンダー４週分配列追加 [2020 年 9 月 6 日から 2020 年 9 月 12 日まで](http://www.jpn.week-numbers.com/37%E5%B9%B4%E7%AC%AC2020%E9%80%B1.html)

## Model と DB

1. Model クラスとマイグレーションファイルを作成

```bash
php artisan make:model Item --migration
```

2. マイグレーション実行

```bash
php artisan migrate
```

3. ダミーデータ(seed)準備 、ファクトリクラスを作成

```bash
php artisan make:factory ItemFactory
```

4. ファクトリクラスに `faker`等を使ってデータ投入できるようにする

[faker チートシート - Qiita](https://qiita.com/tosite0345/items/1d47961947a6770053af)

5. database\seeders\DatabaseSeeder.php に追加

```php
Item::factory(10)->create(); // 10件作成
```

6. seed 実行

```bash
php artisan db:seed
```

---

DB マイグレーション再実行と、データリフレッシュして seed まで

```bash
php artisan migrate:refresh --seed
```

[Database seeding - Laravel docs 8.x](https://laravel.com/docs/8.x/seeding)

## vue multi images upload

- [Laravel Vue.js で画像をアップロード DB 保存までの流れ](http://salary.katsulabo.com/%E3%80%90vue-js%E3%80%91%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%A2%E3%83%83%E3%83%97%E3%83%AD%E3%83%BC%E3%83%89%EF%BC%88%E8%A4%87%E6%95%B0%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%EF%BC%89%E3%81%AE/)
- [【Vue.js】ファイルアップロード（複数ファイル）の渡し方（axios）](http://salary.katsulabo.com/%E3%80%90vue-js%E3%80%91%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%A2%E3%83%83%E3%83%97%E3%83%AD%E3%83%BC%E3%83%89%EF%BC%88%E8%A4%87%E6%95%B0%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%EF%BC%89%E3%81%AE/)
- [Laravel ファイルストレージ：base64 イメージを保存（デコード）する方法？ - it-swarm-ja.tech](https://www.it-swarm-ja.tech/ja/php/laravel%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%B9%E3%83%88%E3%83%AC%E3%83%BC%E3%82%B8%EF%BC%9Abase64%E3%82%A4%E3%83%A1%E3%83%BC%E3%82%B8%E3%82%92%E4%BF%9D%E5%AD%98%EF%BC%88%E3%83%87%E3%82%B3%E3%83%BC%E3%83%89%EF%BC%89%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95%EF%BC%9F/805988561/)

## imagemagick

PDF から png 化して分割

```bash
# pdf to png
pdftoppm -png 2020.10月ランチメニュー.pdf > i2010-10.png

# png crop and split (normal plan)
convert -crop 1290x1210+48+260 i2020-10.png i20-normal.png && \
convert -crop 20%x20% -page +0+0 i20-normal.png -scene 1 img%02d.png

# png crop (special plan)
convert -crop 1048x160+378+1549 i2020-10.png i20-sp1.png && \
convert -crop 20%x100% -page +0+0 i20-sp1.png -scene 1 img%02d.png

convert -crop 1048x160+385+1787 i2020-10.png i20-sp2.png && \
convert -crop 20%x100% -page +0+0 i20-sp2.png -scene 1 img%02d.png

# resize (pattern)
mogrify -resize 210x160 *.png
```

## 課題

[Vue.js で Form の各要素を Component 化する際の覚え書き - Qiita](https://qiita.com/ryo2132/items/2e3fcedaffeff9fc3967)
