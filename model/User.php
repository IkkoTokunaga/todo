<?php

class User
{

    private $user_data;

    public function findById($id){
        $query = sprintf("select * from members where id=%s;", $id);
        $db = new PDO(DSN, USERNAME, PASSWORD);
        $stmt = $db->query($query);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;

    }

    public function getAllUser(){
        $query = "select name from members";
        
        $db = new PDO(DSN, USERNAME, PASSWORD);
        $stmt = $db->query($query);
        $allUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $allUser;

    }

    public function setData($user){

        $this->user_data = $user;

    }

    public function save(){
    
        $query = sprintf(
            "INSERT INTO `members`
                (`name`,`email`,`password`,`created_at`)
            VALUES ('%s', '%s', '%s', NOW());",
            $this->user_data['name'],
            $this->user_data['email'],
            $this->user_data['pass']
        );

        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $stmt->execute();

            $id = $dbh->lastinsertId('id');

            $dbh->commit();

            return $id;

        } catch (PDOException $e) {

            $dbh->rollBack();
            echo "DBエラー".$e->getMessage();
        }
    }

    public function getUserForLogin(){
    
        $db = new PDO(DSN, USERNAME, PASSWORD);

        $query = sprintf("SELECT * FROM common.members WHERE name='%s' AND email='%s';", $this->user_data['name'], $this->user_data['email']);

        $stmt = $db->query($query);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
