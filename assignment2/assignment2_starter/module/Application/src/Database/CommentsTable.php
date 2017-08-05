<?php

namespace Application\Database;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class CommentsTable{

    private $sql;
    private $adapter;

    public function __construct($database, $username, $password)
    {
        $this->adapter = new Adapter([
            'driver' => 'Pdo_Mysql',
            'hostname' => '127.0.0.1',
            'username' => $username,
            'password' => $password,
            'database' => $database,
        ]);

        $this->sql = new Sql($this->adapter);
    }


    public function getComments($id){
        $select = $this->sql
            ->select()
            ->from('comments')
            ->where(['pictures_id' => $id]);

        $query = $this->sql->buildSqlString($select);

        return $this->adapter->query($query)->execute();
    }

    public function insertComment(array $comment){
        $insert = $this->sql
            ->insert()
            ->into('comments')
            ->values($comment);

        $query = $this->sql->buildSqlString($insert);

        return $this->adapter->query($query)->execute();
    }
}
