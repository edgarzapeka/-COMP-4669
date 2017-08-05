<?php

namespace Application\Database;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class TokenTable{
    private $sql;
    private $adapter;

    public function __construct($database, $username, $password)
    {
        $this->adapter = new Adapter([
            'driver'   => 'Pdo_Mysql',
            'hostname' => '127.0.0.1',
            'username' => $username,
            'password' => $password,
            'database' => $database,
        ]);
        $this->sql = new Sql($this->adapter);
    }

    public function getTokens()
    {
        $select = $this->sql
            ->select()
            ->from('login');
        $query = $this->sql->buildSqlString($select);
        return $this->adapter->query($query)->execute();
    }

    public function insertToken(array $token){
        $insert = $this->sql
            ->insert()
            ->into('login')
            ->values($token);

        $query = $this->sql->buildSqlString($insert);

        return $this->adapter->query($query)->execute();
    }
}