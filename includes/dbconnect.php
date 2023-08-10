<?php

$dns = "mysql:host=localhost;dbname=auth";
$user = "root";
$pass= "";
$options= [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
];

try {
    $db= new PDO($dns , $user , $pass , $options);
    $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed ". $e->getMessage();
}