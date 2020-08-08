<?php

class TodoController
{

    public function index()
    {
        $todo_list = Todo::findAll();
        return $todo_list;
    }

    public function detail()
    {
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);

        return $todo;
    }

    public function new()
    {
        $title = $_POST['title'];
        $detail = $_POST['detail'];

        $error_msg = [];
        if(empty($title)){
            $error_msg[] = "タイトルが空です";
        }
        if(empty($detail)){
            $error_msg[] = "詳細が空です";
        }
        if(count($error_msg) > 0){
            $params = sprintf("?title=%s&detail=%s", $title, $detail);
            header("Location: ./new.php" . $params);
        }

        $todo = new Todo();
        $todo->setTitle($title);
        $todo->setDetail($detail);
        $result = $todo->save();

        if($result === false) {
            $params = sprintf("?title=%s&detail=%s", $title, $detail);
            header("Location: ./new.php" . $params);
            }
            header( "Location: ./index.php");
    }
}
