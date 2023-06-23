<?php
require '../vendor/autoload.php';

// ユーザー登録されているか設定
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

// DBに接続
$client = new MongoDB\Client("MONGO URL HERE");

$collection = $client->school_line;
$userData = $collection->users->findOne([ "UserID" => $user_id ]);

$displayName = $userData->DisplayName == null ? $userData->UserID : $userData->DisplayName;
$avatar = $userData->avatarURL == null ? "https://cdn.rena-app.com/avatar.png" : $userData->avatarURL;

$wsclient = new WebSocket\Client("ws://localhost:8082");
if (isset($_POST["send"])) {
    if ($_POST["message"] !== "") {
        $collection->messages->insertOne([
            'UserID' => $user_id,
            'CreatedAt' => time(),
            'Message' => htmlspecialchars($_POST["message"]),
        ]);
        $wsclient->text("Updated");
    }

    header("Location: .");
};


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Chat App</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/chat.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
    <div id="chat-container">
        <ul id="message-list">
        <?php
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://sc-line.rena-app.com/modules/Message.php?token=TOKEN HERE&UserID=".$user_id);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $res = curl_exec($ch);
            curl_close($ch);
            echo $res
        ?>
        </ul>
        <div id="input-container">
            <div id="input-wrapper">
                <form method="post">
                    <input id="message-input" name="message" placeholder="メッセージを入力">
                    <input type="submit" id="send-button" name="send">
                </form>
            </div>
        </div>
    </div>

    <script>
        const scroll = document.getElementById("message-list");
        scroll.scrollTop = scroll.scrollHeight;

        var connection = new WebSocket("ws://localhost:8082");

        connection.onopen = function() {
            console.log('接続しました')
        };

        connection.onerror = function(err) {
            console.log('エラーが発生しました: ' + err)
        };

        connection.onmessage = function() {
            sendPHP("index.php")
            window.location.reload();
        };

        connection.onclose = function() {
            console.log('切断しました')
        };

        function sendPHP(filePath) {
            $.ajax({
                type: "post",
                url: filePath,
                data: {
                    recived: true
                },
                error: function(e) {
                    alert('エラーが発生しました')
                    console.log(e)
                }
            });
        };
    </script>
</body>
</html>

