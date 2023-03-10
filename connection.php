<?php
try {
    $host = 'localhost';
    $dbname = 'ecommerce';
    $user = 'root';
    $password = '';
    $connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $user, $password);
} catch (Exception $e) {
    echo  $e->getMessage();
}
