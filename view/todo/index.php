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
require_once '../../validation/UserValidation.php';
require_once '../../validation/TodoValidation.php';
require_once '../../model/User.php';
require_once '../../model/Todo.php';
require_once '../../controller/UserController.php';
require_once '../../controller/TodoController.php';

$result = "";

if (isset($_POST['new_member'])) {

    $new_member = new UserController();
    $new_member->setNewMember($_POST);
    $result = $new_member->newMember();
}
if (isset($_POST['signin'])) {

    $member = new UserController();
    $member->setMember($_POST);
    $result = $member->login();
}
if (isset($_POST['logout'])) {

    $result = "";
    unset($_SESSION['user']);
    header("Location: index.php");
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
    <!------------------- ログイン画面 ---------------------------->
    <?php if (isset($err_msgs)) : ?>
        <ul>
            <?php foreach ($err_msgs as $err) : ?>
                <li><?= $err; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="" method="post">

    <?php if($result !== "welcome"): ?>
        <div class="member_form">

            <div class="accordion">
                <p>新規登録</p>
                <table class="form_container">
                    <tr>
                        <td>
                            name
                        </td>
                        <td>
                            <input type="text" name="name" id="name" placeholder="名前"
                            value="<?php if(isset($_GET['name'])){echo $_GET['name'];} ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            email
                        </td>
                        <td>
                            <input type="email" name="email" id="email" placeholder="アドレス"
                            value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            password
                        </td>
                        <td>
                            <input type="password" name="pass" id="pass" placeholder="パスワード">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            password
                        </td>
                        <td>
                            <input type="password" name="re_pass" id="re_pass" placeholder="パスワード確認用">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" name="new_member" id="new_member" value="新規登録">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="accordion">
                    <p>ログイン</p>
                    <table class="form_container">
                        <tr>
                            <td>
                                name
                            </td>
                            <td>
                            <input type="text" name="m_name" id="m_name" placeholder="名前"
                            value="<?php 
                            if(isset($_GET['m_name'])){echo $_GET['m_name'];} ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                email
                            </td>
                            <td>
                                <input type="m_email" name="m_email" id="m_email" placeholder="アドレス"
                                value="<?php 
                                if(isset($_GET['m_email'])){echo $_GET['m_email'];} ?>">
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                password
                            </td>
                            <td>
                                <input type="password" name="m_pass" id="m_pass" placeholder="パスワード">
                            </td>
                        </tr>

                        <tr>
                            <td>
                            <input type="submit" name="signin">
                            </td>
                        </tr>
                    </table>
                </div>
        </div>
    <? endif; ?>

    <?php if($result === "welcome"): ?>
    <label for="logout">ログアウト</label><input type="submit" name="logout" id="logout">
    </br>
    </form>
    <?php if(isset($_SESSION['user'])): ?>
    <?= "Welcome" . h($_SESSION['user']['name']) . "さん"; ?>
    <?php endif; ?>
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
    <?php endif; ?>

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