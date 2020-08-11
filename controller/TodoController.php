<?php
require_once '../../validation/TodoValidation.php';

class TodoController
{

    public function index()
    {
        $todo_list = Todo::findAll();
        return $todo_list;
    }

    public function new()
    {
        $data = [
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        ];

        $validation = new TodoValidation();
        $validation->setData($data);
        $check = $validation->check();
        if($check === false){
            $_SESSION['error_msgs'] = $validation->getErrorMessage();
            $params = sprintf("?title=%s&detail=%s", $data['title'], $data['detail']);
            header("Location: ./new.php" . $params);
            exit;
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
            exit;
            }
            header( "Location: ./index.php");
    }

    public function detail()
    {
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);

        return $todo;
    }

    public function edit()
    {
        $todo_id = $_GET['todo_id'];
        $todo = Todo::findById($todo_id);
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return $todo;
        }
        $data = [
            "title" => $_POST['title'],
            "detail" => $_POST['detail']
        ];
        // var_dump($data);
        $validation = new TodoValidation();
        $validation->setData($data);
        $check = $validation->check();
        if($check === false) {
            $_SESSION['error_msgs'] = $validation->getErrorMessage();
            $params = sprintf("?todo_id=%d",
            $todo_id);
            header("Location: ./edit.php" . $params);
            exit;
        }
        $validation = new TodoValidation();
        $validation->setData($data);
        $check = $validation->check();
        if($check === false){
            $_SESSION['error_msgs'] = $validation->getErrorMessage();
            $params = sprintf("?title=%s&detail=%s", $data['title'], $data['detail']);
            header("Location: ./edit.php" . $params);
            exit;
        }

        $validate_data = $validation->getData();
        $title = $validate_data['title'];
        $detail = $validate_data['detail'];
        $update = new Todo();
        $update->setTitle($title);
        $update->setDetail($detail);
        $update->update($todo_id);
        header("Location: ./index.php");
    }
}
