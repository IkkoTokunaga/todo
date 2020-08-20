<?php

class UserValidation {

    private $name;
    private $email;
    private $pass;
    private $err_msgs = [];

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
    public function getPass()
    {
        return $this->pass;
    }
    
    public function checkName()
    {
        $cnt = 0;
        if(empty($this->name)){
            $this->err_msgs[] = "名前を入力してください";
            $cnt++;
        }
        if(mb_strlen($this->name) > 20){
            $this->err_msgs[] = "名前は20文字以内で入力してください";
            $cnt++;
        }
        if($cnt !== 0){
            return false;
        }
        return true;
    }

    public function checkEmail()
    {
        $cnt = 0;
        if(empty($this->email)){
            $this->err_msgs[] = "アドレスを入力してください";
            $cnt++;
        }
        if(mb_strlen($this->email) > 100){
            $this->err_msgs[] = "アドレスは100字以内で記入してください";
            $cnt++;
        }
        if($cnt !== 0){
            return false;
        }
        return true;
    }

    public function checkPass($re_pass)
    {
        $cnt = 0;
        if(empty($this->pass)){
            $this->err_msgs[] = "パスワードを入力してください";
            $cnt++;
        }
        if(mb_strlen($this->pass) < 4){
            $this->err_msgs[] = "パスワードは４文字以上で入力してください";
            $cnt++;
        }
        if($this->pass !== $re_pass){
            $this->err_msgs[] = "同じパスワードを入力してください";
            $cnt++;
        }
        if($cnt !== 0){
            return false;
        }
        return true;
    }

    public function judgePass($pass, $db_pass)
    {
        if($pass !== $db_pass){
            $this->err_msgs[] = "パスワードが違います!!";
            return false;
        }
        return true;
    }

    public function getErrMessage()
    {
        return $this->err_msgs;
    }
}