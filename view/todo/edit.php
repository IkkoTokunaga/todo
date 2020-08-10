<?php
require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

if(isset($_SESSION['error_msgs'])){
    session_start();
    $error_msgs = $_SESSION['erroe_msgs'];
    unset($_SESSION['error_msgs']);
}
// if(isset($_POST['update'])){
    $action = new TodoController();
    $todo = $action->edit();
// }

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集</title>
</head>

<body>
    <div>編集</div>
    <form action="" method="post">
        <div>
            <div>タイトル</div>
            <div>
                <input type="text" name="title" value="<?= $todo['title']; ?>">
            </div>
        </div>
        <div>
            <div>詳細</div>
            <div>
                <textarea name="detail" id="" cols="30" rows="10"><?= $todo['detail']; ?></textarea>
            </div>
        </div>
        <button type="submit" name="update">登録</button>
    </form>
    <?php if (isset($error_msgs)): ?>
    <?php if ($error_msgs) : ?>
        <div>
            <ul>
                <?php foreach ($error_msgs as $error_msg) : ?>
                    <li><?= $error_msg; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php endif; ?>
</body>

</html>