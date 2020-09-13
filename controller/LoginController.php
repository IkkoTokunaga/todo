<?php

class LoginController {
    
    public function login()
    {
        $user_data = $_POST;
        $validation = new LoginValidation();
        $validation->setData($user_data);
        $check_data = $validation->checkData();

        if(!$check_data){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?name=%s&email=%s",$user_data['name'], $user_data['email']);
            header("Location: ./login.php". $params);
            exit;
        }

        $data = $validation->getData();

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