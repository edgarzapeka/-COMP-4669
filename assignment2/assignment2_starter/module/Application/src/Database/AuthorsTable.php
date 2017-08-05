<?php


namespace Application\Database;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class AuthorsTable
{
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

    public function getAllAuthors()
    {
        $select = $this->sql
            ->select()
            ->from('authors');

        $query = $this->sql->buildSqlString($select);

        return $this->adapter->query($query)->execute();
    }

    public function getAuthor($id){
        $select = $this->sql
            ->select()
            ->from('authors')
            ->where(['authors_id' => $id]);

        $query = $this->sql->buildSqlString($select);

        return $this->adapter->query($query)->execute();
    }

    public function insertAuthor(array $author){
        $insert = $this->sql
            ->insert()
            ->into('authors')
            ->values($author);

        $query = $this->sql->buildSqlString($insert);

        return $this->adapter->query($query)->execute();
    }
}