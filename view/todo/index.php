<?php

session_start();
if (isset($_SESSION["error_msgs"])) {
    unset($_SESSION["error_msgs"]);
}
if (isset($_SESSION["user_err"])) {
    $err_msgs = $_SESSION["user_err"];
    unset($_SESSION["user_err"]);
}

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../model/User.php';
require_once '../../model/Todo.php';
require_once '../../controller/UserController.php';
require_once '../../controller/TodoController.php';

if (isset($_POST['new_menber'])) {

    $new_menber = new UserController($_POST);
    $result = $new_menber->newMenber();
}
if (isset($_POST['signin'])) {

    $menber = new UserController($_POST);
    $result = $menber->login();
    echo $result;
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
            <!------------------- ログイン画面 ---------------------------->
            <?php if (isset($err_msgs)) : ?>
                <ul>
                    <?php foreach ($err_msgs as $err) : ?>
                        <li><?= $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form action="" method="post">
                <div class="menber_form">

                    <h2>新規登録</h2>

                    <label for="name">name</label><input type="text" name="name" id="name" placeholder="名前"
                    value="<?php if(isset($_GET['name'])){echo $_GET['name'];} ?>">

                    <label for="email">email</label><input type="email" name="email" id="email" placeholder="アドレス"
                    value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>">

                    <label for="pass">password</label><input type="password" name="pass" id="pass" placeholder="パスワード">

                    <label for="re_pass">password</label><input type="password" name="re_pass" id="re_pass" placeholder="パスワード確認用">

                    <input type="submit" name="new_menber" id="new_menber" value="新規登録">


                    <h2>ログイン</h2>

                    <label for="m_name">name</label><input type="text" name="m_name" id="m_name" placeholder="名前">

                    <label for="m_email">email</label><input type="m_email" name="m_email" id="m_email" placeholder="アドレス">

                    <label for="m_pass">password</label><input type="password" name="m_pass" id="m_pass" placeholder="パスワード">

                    <input type="submit" name="signin">

                </div>
            </form>

            <label>ログアウト</label><input type="submit" name="logout">


            <!----------------------- 新規作成画面 ------------------------>
            <div>
                <a href="./new.php">新規作成</a>
            </div>
            <ul>
                <?php foreach ($todo_list as $todo) : ?>
                    <li>
                        <a href="./detail.php?todo_id=<?= h($todo['id']); ?>">
                            <?= h($todo['title']); ?></a>
                        <button class="delete_btn" data-id="<?= h($todo['id']); ?>">削除</button>
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
        </script>