<?php
$host = 'localhost';
$database = 'librarydb';
$user = 'root';
$password = '';
$host = '127.0.0.1';
$charset = 'utf8';
$options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
?>