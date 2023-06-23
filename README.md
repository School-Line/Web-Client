# School LINEとは？
School LINEとは、学校の授業中にPCで堂々とLINEをするために作ったリアルタイムで双方向通信が可能なチャットアプリである。
そもそもなんでこんなツールを作ったかというと他クラスの奴らと喋りたいというわけのわからない理由である。バレたら確実に詰みでしょうね。

# 使用方法
[サイトにアクセスして](https://sc-line.rena-app.com/login.php)ログインしてください<br>
セッションで管理しているため、ブラウザを閉じるなどをするとログアウトされます<br>
ユーザーの登録方法は[こちらのページを参照](https://github.com/School-Line/Web-Dashboard)してください

# サーバーに組み込む
## 準備
1. `MONGO URL HERE`と書いてある場所にMongoDBのURLを記入してください
<br>例) mongodb+srv://\<Password>:\<UserName>@mongodb.net/
2. `TOKEN HERE`と書いてある場所に適当な文字列を入れてください。セキュリティ強化です
3. [WebSocketサーバー](https://github.com/School-Line/WebSocket-Server)を起動してください

ユーザーの登録方法は[こちらのページを参照](https://github.com/School-Line/Web-Dashboard)してください

## 公開方法
### Apacheの場合
1. DocumentRootを`public/`にします
2. PHPとcurlを有効化しておいてください
3. 起動します

### PHP内蔵サーバーの場合
`php -S localhost:8080 -t ./public`コマンドを実行して[アクセスしてください](http://localhost:8080)

# セキュリティ向上のために
Basic認証や、パスワードを強化するなどの対処が必要です