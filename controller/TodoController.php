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
        $data = [
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        ];

        $validation = new TodaValidation();
        $validation->setData($data);
        if($validation->check() === false){
            $params = sprintf("?title=%s&detail=%s", $data['title'], $data['detail']);
            header("Location: ./new.php" . $params);
        }
//ちゃんとvalidationを通過した正常値という意味も含めて
        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];

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
