<?php


class UserController {

    public function save()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $user_date = $_POST;
            $validation = new UserValidation();
            $validation->setDate($user_date);
            $check_date = $validation->checkDate();
            if(!$check_date){
                $_SESSION['user_err'] = $validation->getErrMessage();
                $params = sprintf("?name=%s&email=%s",$user_date['name'], $user_date['email']);
                header("Location: ./new.php". $params);
                exit;
            }

            $data = $validation->getDate();

            $new_user = new User();
            $new_user->setData($data);
            $id = $new_user->save();
            if(!$id){
                $params = sprintf("?name=%s&email=%s",$data['name'], $data['email']);
                header("Location: ./new.php". $params);
                exit;
            }
            $user = $new_user->findById($id);
            $_SESSION['user'] = $user;
            header("Location: ../todo/index.php");
            exit;
        }
        header("Location: ./new.php");
        exit; 
    }

}