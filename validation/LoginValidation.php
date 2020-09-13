<?php

class LoginValidation {

    private $data;
    private $err_msgs = [];

    public function setData($data)
    {
        $this->data = $data;
    }
    public function getData()
    {
        return $this->data;
    }
    
    public function checkData()
    {
        if(empty($this->data['name'])){
            $this->err_msgs[] = "名前を入力してください";
        }
        if(mb_strlen($this->data['name']) > 20){
            $this->err_msgs[] = "名前は20文字以内で入力してください";
        }

        if(empty($this->data['email'])){
            $this->err_msgs[] = "アドレスを入力してください";
        }
        if(mb_strlen($this->data['email']) > 100){
            $this->err_msgs[] = "アドレスは100字以内で記入してください";
        }

        if(empty($this->data['pass'])){
            $this->err_msgs[] = "パスワードを入力してください";
        }
        elseif(mb_strlen($this->data['pass']) < 4){
            $this->err_msgs[] = "パスワードは４文字以上で入力してください";
        }
        else{
            $action = new User();
            $action->setdata($this->data);
            $db_pass = $action->getLoginPass();
            
            if($this->data['pass'] !== $db_pass) {
                $this->err_msgs[] = "パスワードが違います!!";
            }
        }

        if(!empty($this->err_msgs)){
            return false;
        }
        return true;
    }

    public function getErrMessage(){

        return $this->err_msgs;
    }
}