ぼくがかんがえたさいきょうしぃえむえす
-----------

ちいさなサイトを作りたいんだけど、WordPressはデータベース使うんだよなあ。
WordPressはできあいのテンプレートがたくさんあるのはいいけど、カスタマイズに手間取りそうだなあ。
WordPressの勉強したいんじゃなくて、サイトを作りたいんだけどなあ。  
と、思った。  
で、Bokupress(ボクプレス)を作ってみた。

[source](https://github.com/tjtjtj/bokupress)  
demo(準備中)


### Bokupressの特徴

- データベースを使わない
- ディレクトリ/ファイル構造がURLに
- ファイルがページに
- HTMLがテンプレートに


### ディレクトリ/ファイル構造がURLに

公開ディレクトリのディレクトリ名・ファイル名からURLを生成します。
ファイルの拡張子は無視します。

~~~
   file                 URL                
  -------------------- ------------------
   site/                /site/
    |-- index.md        /site/index
    `-- doc/            /site/doc
         `- hello.md    /site/doc/hello
~~~



### ファイルがページに

公開ディレクトリ下にファイルを追加するとページが追加されます。  
公開ディレクトリ下にディレクトリを追加するとナビゲーションが追加されます。

~~~
   file                 URL                render
  -------------------- ------------------ -----------------
   site/                /site/             ディレクトリ下のindexをレンダリング
    |-- index.md        /site/index        index.md
    `-- doc/            /site/doc          ディレクトリ下のファイル一覧
         `- hello.md    /site/doc/hello    hello.md
~~~

### HTMLがテンプレートに

多くのCMSはテンプレートにテンプレートタグを埋め込むことを要求します。
しかし、テンプレートタグを埋め込んでしまうと、テンプレートエンジンに処理させなけばWebブラウザで確認することができません。

BokupressのテンプレートエンジンはPHPTALです。
PHPTALはテンプレートのHTMLを壊さないので、テンプレートファイルをWebブラウザで直接確認できます。

~~~
 +---------------+                 +---------------+
 | template.html | -> 直接確認  ->  |  Webブラウザ   |
 |               |                 |               |
 |               | -> bokupress -> |               |
 +---------------+                 +---------------+
~~~

PHPTALを利用する利点は
[PHPTAL日本語訳　最新版](http://labs.wardish.jp/archives/70.html)
の
[なぜPHPTALを使うのか](http://labs.wardish.jp/archives/70.html#whyusingphptal)
を参照してください。

