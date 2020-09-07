<?php

require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../validation/UserValidation.php';
require_once '../../validation/TodoValidation.php';
require_once '../../model/User.php';
require_once '../../model/Todo.php';
require_once '../../controller/UserController.php';
require_once '../../controller/TodoController.php';

$action = new User();
$users = $action->AllUserName();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
</head>
<body>
    <ul>
        <?php foreach($users as $user) :?>
         <li><?= $user['name']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>