<?php
require "../../vendor/autoload.php";
date_default_timezone_set("Asia/Tokyo");

if (!isset($_GET["token"]) || !isset($_GET["UserID"])) return;

if ($_GET["token"] !== "TOKEN HERE") {
   echo "<div>セッションが無効です<br>ログインしなおしてください</div>";
   return;
}

$client = new MongoDB\Client("MONGO URL HERE");
$collection = $client->school_line;
$messages = $collection->messages->find();

foreach ($messages as $message) {
    $userData = $collection->users->findOne([ 'UserID' => $message["UserID"]]);
    $displayName = $userData->DisplayName == null ? $userData->UserID : $userData->DisplayName;
    $avatar = $userData->avatarURL == null ? "https://cdn.rena-app.com/avatar.png" : $userData->avatarURL;
    $time = date('Y/m/d/ h:i', $message["CreatedAt"]);
    if ($message["UserID"] !== $_GET["UserID"]) { ?>
        <li class="message received">
            <div class="message-info">
                <div class="sender-info">
                    <img class="sender-icon" src="<?php echo $avatar ?>" alt="User Icon">
                    <span class="sender-name"><?php echo $displayName ?></span>
                </div>
                <span class="message-time"><?php echo $time ?></span>
            </div>
            <div class="message-body">
                <p><?php echo $message["Message"] ?></p>
            </div>
        </li>
    <?php } else { ?>
        <li class="message sent">
            <div class="message-info">
                <div class="sender-info">
                    <img class="sender-icon" src="<?php echo $avatar ?>" alt="User Icon">
                    <span class="sender-name"><?php echo $displayName ?></span>
                </div>
                <span class="message-time"><?php echo $time ?></span>
            </div>
            <div class="message-body">
                <p><?php echo $message["Message"] ?></p>
            </div>
        </li>
<?php
    }
}
?>