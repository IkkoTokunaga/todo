<?php

class LoginValidation {

    private $date;
    private $err_msgs = [];

    public function setDate($date)
    {
        $this->date = $date;
    }
    public function getDate()
    {
        return $this->date;
    }
    
    public function checkDate()
    {
        if(empty($this->date['name'])){
            $this->err_msgs[] = "名前を入力してください";
        }
        if(mb_strlen($this->date['name']) > 20){
            $this->err_msgs[] = "名前は20文字以内で入力してください";
        }

        if(empty($this->date['email'])){
            $this->err_msgs[] = "アドレスを入力してください";
        }
        if(mb_strlen($this->date['email']) > 100){
            $this->err_msgs[] = "アドレスは100字以内で記入してください";
        }

        if(empty($this->date['pass'])){
            $this->err_msgs[] = "パスワードを入力してください";
        }
        elseif(mb_strlen($this->date['pass']) < 4){
            $this->err_msgs[] = "パスワードは４文字以上で入力してください";
        }
        if(isset($_POST['new_user'])){
            if($this->date['pass'] !== $this->date['re_pass']){
                $this->err_msgs[] = "同じパスワードを入力してください";
            }
        }
        if(!empty($this->err_msgs)){
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