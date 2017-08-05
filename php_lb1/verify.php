<?php

require 'vendor/autoload.php';
use Zend\Crypt\Password\Bcrypt;

$bcrypt = new Bcrypt();

var_dump($argv);

if ( $bcrypt->verify($argv[1], $argv[2])){
    echo "Valid" . PHP_EOL;
} else{
    echo "Invalid" . PHP_EOL;
}