<?php


require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = new TodoController();
    $action->new();
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
                <input type="text" name="title">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <button type="submit">登録</button>
    </form>
    <a href="./index.php">戻る</a>
</body>

</html>