# KARUTA for Instagram [![Build Status](https://travis-ci.org/mamor/igkaruta.png)](https://travis-ci.org/mamor/igkaruta)
AngularJS x LaravelによるInstagramの写真を使ったカルタです。

* AngularJS https://angularjs.org/
* Laravel http://laravel.com/
* Instagram http://instagram.com/

---

## 環境構築

### Instagramアプリを作成する
http://instagram.com/developer/clients/register/ から作成します。

### このレポジトリのソースを取得する
次のコマンドを実行します。

    $ git clone git@bitbucket.org:mamor/karuta.git
    $ cd karuta/

#### 設定
app/config/.env.default を app/config/.env としてコピーして適切に編集します。

#### 依存関係のインストール
次のコマンドを実行します。

    $ composer install

---

## 開発用
Mac OS X Mavericks で確認しています。

### IDEヘルパの作成
次のコマンドを実行します。DBエラーが発生する場合は正しい接続設定をして下さい。

    $ make ide

### プロファイラの設定
次のコマンドを実行します。

    $ php artisan debugbar:publish

app/config/local.default/app.php を app/config/local/app.php としてコピーすると有効になります。

### PHPUnit
次のコマンドを実行します。

    $ phpunit

### Jasmine with gulp.js and Karma
必要なモジュールをインストールします。npm と bower は別途インストールして下さい。

    $ npm install
    $ bower install

次のコマンドを実行します。gulp と karma は別途インストールして下さい。

    $ gulp karma

### その他
Makefile と gulpfile.js を見て下さい。

## License
Copyright 2014, Mamoru Otsuka. Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
