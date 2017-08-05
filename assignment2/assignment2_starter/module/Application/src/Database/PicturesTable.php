<?php
/**
 * Created by PhpStorm.
 * User: edz
 * Date: 2017-06-22
 * Time: 4:47 PM
 */

namespace Application\Database;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class PicturesTable{

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

    public function getPictures(){
        $select = $this->sql
            ->select()
            ->from('pictures');

        $query = $this->sql->buildSqlString($select);

        return $this->adapter->query($query)->execute();
    }

    public function insertPicture(array $picture){
        $insert = $this->sql
            ->insert()
            ->into('pictures')
            ->values($picture);

        $query = $this->sql->buildSqlString($insert);

        return $this->adapter->query($query)->execute();
    }

}