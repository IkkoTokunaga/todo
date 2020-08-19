<?php

require_once '../../validation/UserValidation.php';

class UserController {

    private $name;
    private $email;
    private $pass;
    private $re_pass;


    public function __construct($post)
    {
        if (!empty($post['name'])) {
            $this->name = $post['name'];
            $this->email = $post['email'];
            $this->pass = $post['pass'];
            $this->re_pass = $post['re_pass'];
        }
        if (!empty($post['m_name'])) {
            $this->name = $post['m_name'];
            $this->email = $post['m_email'];
            $this->pass = $post['m_pass'];
        }
    }

    public function newMenber()
    {
        $validation = new UserValidation();
        $validation->setName($this->name);
        $check_name = $validation->checkName();
        $validation->setEmail($this->email);
        $check_email = $validation->checkEmail();
        $validation->setPass($this->pass);
        $check_pass = $validation->checkPass($this->re_pass);
        if(!$check_name || !$check_email || !$check_pass){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?name=%s&email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }

        $user['name'] = $validation->getName();
        $user['email'] = $validation->getEmail();
        $user['pass'] =  $validation->getPass();

        $new_menber = new User();
        $new_menber->setUser($user);
        $result = $new_menber->newMenber();
        if($result === false){
            $params = sprintf("?name=%s&email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }
        return "welcome";
    }

    public function login()
    {
        
    }




}