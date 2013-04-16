チュートリアル
=============

ここではBokupresを簡単に試す方法を説明します。

### インストール

composer でとってくる

<pre>
composer 
</pre>


### 起動

PHPビルトインウェブサーバーで動かす

<pre>
cd bokupress/bokusample
php -s localhost:8001
</pre>

[http://localhost:8001](http://localhost:8001) をWebブラウザで開いてください。Bokupresのサンプルサイトが表示されます。


### ページを追加する

<pre>
cd bokupress/bokusample/docs
echo "hello, world"    > hello.md
echo "---------------" >> hello.md
echo " "               >> hello.md
echo "こんにちは！"     >> hello.md
</pre>

[localhost:8001/bokusample/doc](localhost:8001/bokusample/doc) を確認してください。一覧に "hello, world" が追加されたでしょうか。
"詳細"をクリックするとMarkdownで書いた内容が表示されます。





