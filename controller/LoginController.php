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

        $user = $validation->getDate();

        $login_user = new User();
        $login_user->setUser($user);
        $getUser = $login_user->getUserForLogin();
        if(!$getUser){
            $params = sprintf("?name=%s&email=%s",$user['name'], $user['email']);
            header("Location: ./login.php". $params);
            exit;
        }
        $check_pass = $validation->judgePass($user['pass'], $getUser['password']);
        if(!$check_pass){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?name=%s&email=%s",$user['name'], $user['email']);
            header("Location: ./login.php". $params);
            exit;
        }
        $_SESSION['user'] = $getUser;
    }


}