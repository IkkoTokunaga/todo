<?php

class Todo
{
    public $title;
    public $detail;
    public $status;

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

    //dbからデータを取り出して連想配列にして返すよ。もし取り出しに失敗したら空の配列を返すよ
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
    //呼び出せばdbから全件抽出して値を返すよ、失敗したらからの配列を返すよ
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
            'SELECT * FROM common.todos WHERE id = %s', $todo_id
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

        try{
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $result = $stmt->execute();
    
            $dbh->commit();
            return $result;
        } catch(PDOException $e) {

            $dbh->rollBack();
            echo $e->getMessage();
        }
    }

    public function update()
    {
        $query = sprintf(
            "UPDATE `todos` SET title = %s, detail = %s",
            $this->title,
            $this->detail
        );

        try{
            $dbh = new PDO(DSN, USERNAME, PASSWORD);

            $dbh->beginTransaction();

            $stmt = $dbh->prepare($query);
            $stmt->execute();
    
            $dbh->commit();
        } catch(PDOException $e) {

            $dbh->rollBack();
            echo $e->getMessage();
        }
    }

}

