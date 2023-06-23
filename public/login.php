<?php
require "../vendor/autoload.php";

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$err_msg = '';

if(isset($_POST['login'])) {
    $user_id = $_POST['UserID'];
    $password = $_POST['Password'];
    $password = hash('sha256', $password);


    $client = new MongoDB\Client("MONGO URL HERE");
    $collection = $client->school_line->users;

    $data = $collection->findOne(["UserID" => $user_id, "Password" => $password]);

    if (isset($data)){
        session_start();
        $_SESSION['user_id'] = $data["UserID"];
        header('Location: index.php');
        exit;
    } else {
        $err_msg = "ユーザー名またはパスワードが間違っています";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-Chat | ログイン</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
<div class="container">
    <h1>R-Chat ログイン</h1>
    <form method="post" action="">
        <p><?= $err_msg ?></p>
        <label for="UserID">アカウントID</label>
        <input type="id" name="UserID" class="text_input">
        <label for="Password">パスワード</label>
        <input type="password" name="Password" class="text_input">
        <input type="submit" name="login" class="submit_button" valueS="ログイン">
    </form>
</div>
</body>
</html>