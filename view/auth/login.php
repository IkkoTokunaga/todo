<?php

session_start();
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../validation/UserValidation.php';
require_once '../../model/User.php';
require_once '../../controller/UserController.php';


if (isset($_POST['signin'])) {

    $member = new UserController();
    $member->setMember($_POST);
    $member->login();

}
if (isset($_POST['new_member'])) {

    header("Location: ../user/new.php");

}

if(isset($_SESSION['user'])){
    header("Location: ../todo/index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/index.css">
    <title>ログイン</title>
</head>
<body>
    <p>ログイン</p>
    <form action="" method="post">

        <table class="form_container">
            <tr>
                <td>
                    name
                </td>
                <td>
                    <input type="text" name="m_name" id="m_name" placeholder="名前" value="<?php if (isset($_GET['m_name'])) {echo $_GET['m_name'];} ?>">
                </td>
            </tr>
    
            <tr>
                <td>
                    email
                </td>
                <td>
                    <input type="m_email" name="m_email" id="m_email" placeholder="アドレス" value="<?php if (isset($_GET['m_email'])) {echo $_GET['m_email']; } ?>">
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
                    <input type="submit" name="signin" value="ログイン">
                    <input type="submit" name="new_member" value="初めての方">
                </td>
            </tr>
        </table>
    </form>
    <?php if (isset($_SESSION["user_err"])): ?>
        <?php $err_msgs = $_SESSION["user_err"]; ?>
        <?php foreach($err_msgs as $err): ?>
            <p><?= $err; ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION["user_err"]); ?>
    <?php endif; ?>



</body>
</html>


