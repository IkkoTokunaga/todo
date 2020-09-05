<?php

class User
{

    private $name;
    private $email;
    private $pass;

    public function setUser($user)
    {
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->pass = $user['pass'];
    }

    public function newMenber()
    {
        $query = sprintf(
            "INSERT INTO `menbers`
                (`name`,`email`,`password`,`created_at`)
            VALUES ('%s', '%s', '%s', NOW());",
            $this->name,
            $this->email,
            $this->pass
        );

        try {
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $result = $stmt->execute();

            $dbh->commit();
            return $result;
        } catch (PDOException $e) {

            $dbh->rollBack();
            echo "DBエラー".$e->getMessage();
        }
    }

    public function login_user()
    {
        $db = new PDO(DSN, USERNAME, PASSWORD);

        $query = sprintf("SELECT * FROM common.menbers WHERE name='%s' AND email='%s'", $this->name, $this->email);

        $stmt = $db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
