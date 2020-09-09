<?php

session_start();
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../validation/UserValidation.php';
require_once '../../model/User.php';
require_once '../../controller/UserController.php';

if (isset($_SESSION["user_err"])) {
    $err_msgs = $_SESSION["user_err"];
}



if (isset($_POST['new_member'])) {

    $controller = new UserController();
    // $controller->setNewMember($_POST);
    $controller->save();

}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/index.css">
    <title>新規会員登録</title>
</head>

<body>
    <form action="" method="post">

        <div class="member_form">

            <div class="accordion">
                <p>新規登録</p>
                <table class="form_container">
                    <tr>
                        <td>
                            name
                        </td>
                        <td>
                            <input type="text" name="name" id="name" placeholder="名前" value="<?php if (isset($_GET['name'])) {echo $_GET['name'];} ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            email
                        </td>
                        <td>
                            <input type="email" name="email" id="email" placeholder="アドレス" value="<?php if (isset($_GET['email'])) {echo $_GET['email'];} ?>">
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
        <?php if(isset($_SESSION['user_err'])): ?>    
        <?php foreach($err_msgs as $err): ?>
            <p><?= $err; ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION["user_err"]); ?>
        <?php endif; ?>


</body>

</html>