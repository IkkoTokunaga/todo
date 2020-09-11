<?php


class UserController {

    public function save()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            ////postの値を変数に格納しておく
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

            //validationを通ったものを使う
            $user = $validation->getDate();

            //DBへ登録
            $new_user = new User();
            $new_user->setUser($user);
            $result = $new_user->newUser();
            if(!$result){
                $params = sprintf("?name=%s&email=%s",$this->name, $this->email);
                header("Location: ./new.php". $params);
                exit;
            }
            $user = $new_user->login_user();
            $_SESSION['user'] = $user;
            header("Location: ../todo/index.php");
            exit;
        }
        header("Location: ./new.php");
        exit; 
    }

}