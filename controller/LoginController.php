<?php

class LoginController {
    
    public function login()
    {
        $user_date = $_POST;
        $validation = new UserValidation();
        $validation->setDate($user_date);
        $check_date = $validation->checkDate();

        if(!$check_date){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?name=%s&email=%s",$user_date['name'], $user_date['email']);
            header("Location: ./login.php". $params);
            exit;
        }

        $data = $validation->getDate();

        $login_user = new User();
        $login_user->setData($data);
        $user = $login_user->getUserForLogin();
        if(!$user){
            $params = sprintf("?name=%s&email=%s",$data['name'], $data['email']);
            header("Location: ./login.php". $params);
            exit;
        }
        $check_pass = $validation->judgePass($data['pass'], $user['password']);
        if(!$check_pass){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?name=%s&email=%s",$data['name'], $data['email']);
            header("Location: ./login.php". $params);
            exit;
        }
        $_SESSION['user'] = $user;
    }


}