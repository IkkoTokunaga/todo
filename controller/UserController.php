<?php


class UserController {

    private $name;
    private $email;
    private $pass;
    private $re_pass;


    public function setNewMember($post)
    {
        $this->name = $post['name'];
        $this->email = $post['email'];
        $this->pass = $post['pass'];
        $this->re_pass = $post['re_pass'];

    }

    public function setMember($post)
    {
        $this->name = $post['m_name'];
        $this->email = $post['m_email'];
        $this->pass = $post['m_pass'];
    }

    public function newMember()
    {
        //validationを通す
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

        //validationを通ったものを使う
        $user['name'] = $validation->getName();
        $user['email'] = $validation->getEmail();
        $user['pass'] =  $validation->getPass();

        //DBへ登録
        $new_member = new User();
        $new_member->setUser($user);
        $result = $new_member->newMember();
        if(!$result){
            $params = sprintf("?name=%s&email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }
        $user = $new_member->login_user();
        $_SESSION['user'] = $user;
        return "welcome";
    }

    public function login()
    {
        $validation = new UserValidation();
        $validation->setName($this->name);
        $check_name = $validation->checkName();
        $validation->setEmail($this->email);
        $check_email = $validation->checkEmail();

        if(!$check_name || !$check_email){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?m_name=%s&m_email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }

        $user['name'] = $validation->getName();
        $user['email'] = $validation->getEmail();
        $user['pass'] = $this->pass;

        $login_user = new User();
        $login_user->setUser($user);
        $user = $login_user->login_user();
        if(!$user){
            $params = sprintf("?m_name=%s&m_email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }
        $check_pass = $validation->judgePass($this->pass, $user['password']);
        if(!$check_pass){
            $_SESSION['user_err'] = $validation->getErrMessage();
            $params = sprintf("?m_name=%s&m_email=%s",$this->name, $this->email);
            header("Location: index.php". $params);
            exit;
        }
        $_SESSION['user'] = $user;
        return "welcome";
    }

}