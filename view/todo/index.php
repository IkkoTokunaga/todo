<?php

session_start();
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../validation/UserValidation.php';
require_once '../../validation/TodoValidation.php';
require_once '../../model/User.php';
require_once '../../model/Todo.php';
require_once '../../controller/UserController.php';
require_once '../../controller/TodoController.php';

if (isset($_SESSION["error_msgs"])) {
    unset($_SESSION["error_msgs"]);
}

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
}

if (isset($_POST['logout'])) {

    header("Location: ../auth/logout.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $action = new TodoController();
    $todo_list = $action->delete();
}


$action = new TodoController;
$todo_list = $action->index();
?>
<!DOCTYPEhtml>
    <htmllang="ja">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../../css/index.css">
            <title>TODOリスト</title>
        </head>

        <body>

            <?php if(isset($_SESSION['user'])) : ?>
                <?= "Welcome" . h($_SESSION['user']['name']) . "さん"; ?>
            <?php endif; ?>
                <form action="" method="post">
                <input type="submit" name="logout" id="logout" value="ログアウト">
                </form>
                <!----------------------- 新規作成画面 ------------------------>
                <div>
                    <a href="./new.php">新規作成</a>
                </div>
                <ul>
                    <?php foreach ($todo_list as $todo) : ?>
                        <li>
                            <a href="./detail.php?todo_id=<?= $todo['id']; ?>">
                                <?= h($todo['title']); ?></a>
                            <button class="delete_btn" data-id="<?= $todo['id']; ?>">削除</button>
                        </li> <?php endforeach; ?>
                </ul>

            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        </body>

        </html>
        <script>
            $(".delete_btn").on('click', function() {
                const todo_id = $(this).data('id');
                alert("delete");
                window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
            });

            $("#logout").on('click', function(){
                alert("ログアウトしますか？");
            });
        </script>