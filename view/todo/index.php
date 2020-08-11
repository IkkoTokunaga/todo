<?php

session_start();

require_once '../../config/database.php';
require_once '../../model/Todo.php';
require_once '../../controller/TodoController.php';

if(isset($_GET['action']) && $_GET['action'] === 'delete') {
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
        </script>