<?php

require 'vendor/autoload.php';
use Zend\Crypt\Password\Bcrypt;

$bcrypt = new Bcrypt();
$pass = $bcrypt->create($argv[1]);

echo $pass . PHP_EOL;