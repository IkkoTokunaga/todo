<?php

class LoginController {
    
    public function login()
    {
        $user_date = $_POST;
        $validation = new UserValidation();
        $validation->setDate($user_date);
        $check_date = $validation->checkDate();
        // $validation->setEmail($this->email);
        // $check_email = $validation->checkEmail();

        if(!$check_date){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?m_name=%s&m_email=%s",$user_date['name'], $user_date['pass']);
            header("Location: ./login.php". $params);
            exit;
        }

        $user = $validation->getDate();

        $login_user = new User();
        $login_user->setUser($user);
        $getUser = $login_user->login_user();
        if(!$getUser){
            $params = sprintf("?m_name=%s&m_email=%s",$user['name'], $user['pass']);
            header("Location: ./login.php". $params);
            exit;
        }
        $check_pass = $validation->judgePass($user['pass'], $getUser['password']);
        if(!$check_pass){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?m_name=%s&m_email=%s",$user['name'], $user['pass']);
            header("Location: ./login.php". $params);
            exit;
        }
        $_SESSION['user'] = $getUser;
    }


}