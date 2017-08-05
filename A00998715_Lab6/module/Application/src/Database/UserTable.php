<?php
namespace Application\Database;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

class UserTable
{
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

    public function getUsers()
    {
        $select = $this->sql
            ->select()
            ->from('users');
        $query = $this->sql->buildSqlString($select);
        return $this->adapter->query($query)->execute();
    }
}