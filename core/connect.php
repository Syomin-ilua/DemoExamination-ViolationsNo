<?php

session_start();

$host = "localhost";
$dbName = "violationsNo";
$userName = "root";
$password = "root";
$port = 3306;


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;port=$port;", $userName, $password);
} catch(PDOException $exception) {
    echo "Ошибка подключения";
}


?>