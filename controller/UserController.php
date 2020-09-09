<?php


class UserController {

    // private $name;
    // private $email;
    // private $pass;
    // private $re_pass;


    // public function set($post)
    // {
    //     $this->name = $post['name'];
    //     $this->email = $post['email'];
    //     $this->pass = $post['pass'];
    //     $this->re_pass = $post['re_pass'];

    // }

    // public function setMember($post)
    // {
    //     $this->name = $post['m_name'];
    //     $this->email = $post['m_email'];
    //     $this->pass = $post['m_pass'];
    // }

    public function save()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            ////postの値を変数に格納しておく
            $user_date = $_POST;
            //validationを通す
            $validation = new UserValidation();
            $validation->setDate($user_date);
            $check_date = $validation->checkDate();
            // $validation->setEmail($this->email);
            // $check_email = $validation->checkEmail();
            // $validation->setPass($this->pass);
            // $check_pass = $validation->checkPass($this->re_pass);
            if(!$check_date){
                $_SESSION['user_err'] = $validation->getErrMessage();
                $params = sprintf("?name=%s&email=%s",$user_date['name'], $user_date['email']);
                header("Location: ./new.php". $params);
                exit;
            }

            //validationを通ったものを使う
            $user = $validation->getDate();
            // $user['email'] = $validation->getEmail();
            // $user['pass'] =  $validation->getPass();

            //DBへ登録
            $new_member = new User();
            $new_member->setUser($user);
            $result = $new_member->newMember();
            if(!$result){
                $params = sprintf("?name=%s&email=%s",$this->name, $this->email);
                header("Location: ./new.php". $params);
                exit;
            }
            $user = $new_member->login_user();
            $_SESSION['user'] = $user;
            header("Location: ../todo/index.php");
            exit;
        }
        header("Location: ./new.php");
        exit; 
    }

}