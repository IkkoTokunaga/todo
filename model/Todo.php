<?php

class Todo
{
    public $title;
    public $detail;
    public $status;
    public $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($todo_id)
    {
        $this->id = $todo_id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getDetail()
    {
        return $this->detail;
    }
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public static function findByQuery($query)
    {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmh = $dbh->query($query);
        if ($stmh) {
            $result = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }
    public static function findAll()
    {
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $query = "SELECT * FROM todos";
        $stmh = $dbh->query($query);

        if ($stmh) {
            $result = $stmh->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = [];
        }
        return $result;
    }
    //渡したIDを使ってDBのIDを取り出して返すよー
    public static function findById($todo_id)
    {
        $query = sprintf(
            'SELECT * FROM common.todos WHERE id = %s',
            $todo_id
        );
        $dbh = new PDO(DSN, USERNAME, PASSWORD);
        $stmt = $dbh->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function save()
    {
        $query = sprintf(
            "INSERT INTO `todos`
                (`title`,`detail`,`status`,`created_at`,`updated_at`)
            VALUES ('%s', '%s', 0, NOW(), NOW());",
            $this->title,
            $this->detail
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
            echo $e->getMessage();
        }
    }

    public function update($todo_id)
    {
        $query = sprintf(
            "UPDATE todos SET title='%s', detail='%s' WHERE id=%d",
            $this->title,
            $this->detail,
            $todo_id
        );

        try {
            $db = new PDO(DSN, USERNAME, PASSWORD);

            $db->beginTransaction();

            $stmt = $db->prepare($query);
            $stmt->execute();

            $db->commit();
        } catch (PDOException $e) {

            $db->rollBack();
            echo $e->getMessage();
        }
    }

    public static function isExistById($todo_id)
    {
        $db = new PDO(DSN, USERNAME, PASSWORD);
        $query = sprintf("SELECT * FROM todos WHERE id=%s", $todo_id);
        $stmt = $db->query($query);
        //int型だとfalseにならず
        if(!$stmt || empty($stmt)){
            return false;
        }
        return true;
    }

    public function delete()
    {
        try {
            $db = new PDO(DSN, USERNAME, PASSWORD);

            $db->beginTransaction();
            $query = sprintf("DELETE FROM todos WHERE id=%s", $this->id);

            $stmt = $db->prepare($query);
            $result = $stmt->execute();

            $db->commit();

        } catch (PDOException $e) {
            $db->rollBack();

            echo $e->getMessage();
            $result = false;
        }
        return $result;
    }
}
