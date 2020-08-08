<?php

require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

$action = new TodoController;
$todo_list = $action->index();

// var_dump($todo_list);

?>
<!DOCTYPEhtml>
    <htmllang="ja">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>TODOリスト</title>
        </head>

        <body>
            <div>
                <a href="./new.php">新規作成</a>
            </div>
            <ul>
                <?php foreach ($todo_list as $todo) : ?>
                    <li>
                        <a href="./detail.php?todo_id=<?php echo $todo['id']; ?>">
                            <?php echo $todo['title']; ?></a>
                    </li> <?php endforeach; ?>
            </ul>
        </body>

        </html>