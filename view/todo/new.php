<?php
session_start();
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new TodoController();
    $action->new();
}

$title = '';
$detail = '';
if($_SERVER["REQUEST_METHOD"]==="GET"){
    if(isset($_GET['title'])) { 
        $title = $_GET['title'];
    } 
    if(isset($_GET['detail'])) {
    $detail = $_GET['detail']; 
    }
    
}

if(isset($_SESSION['error_msgs'])){
    $error_msgs = $_SESSION['error_msgs'];
    unset($_SESSION['error_msgs']);
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規作成</title>
</head>

<body>
    <div>新規作成</div>
    <form action="./new.php" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title"
                value="<?= h($title); ?>">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail" id="" cols="30" rows="10"><?= h($detail); ?></textarea>
            </div>
        </div>
            <?php if(isset($error_msgs)): ?>
                <?php foreach($error_msgs as $error_msg): ?>
                <?= $error_msg; ?>
                </br>
                <?php endforeach; ?>
            <?php endif; ?>
        <button type="submit">登録</button>
    </form>
    <a href="./index.php">戻る</a>
</body>

</html>