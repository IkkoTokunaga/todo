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

    public function delete()
    {
        $todo_id = $_GET['todo_id'];
        $is_exist = Todo::isExistById($todo_id);
        if(!$is_exist){
            session_start();
            $_SESSION['error_msgs'] = [
                sprintf("id=%sに該当するレコードがありません", $todo_id)
            ];
            header("Location: ./index.php");
        }

        $todo = new Todo();
        $todo->setId($todo_id);
        $result = $todo->delete();
        if($result === false) {
            $_SESSION['error_msgs'] = [
                sprintf("削除に失敗しました。 id=%s", $todo_id)
            ];
        }

        header("Location: ./index.php");
    }
}
