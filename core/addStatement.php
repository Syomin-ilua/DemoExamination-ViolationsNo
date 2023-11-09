<?php

session_start();
require_once "./connect.php";


$userId = $_POST['userId'];
$userSurname = $_POST['userSurname'];
$userName = $_POST['userName'];
$userPatronymic = $_POST['userPatronymic'];
$numberAuto = $_POST['numberAuto'];
$descriptionViolation = $_POST['descriptionViolation'];
$statusStatement = "новое";

if(empty($numberAuto) || empty($descriptionViolation) || empty($userId) || empty($userSurname) || empty($userName) || empty($userPatronymic)) {
    header("Location: ../newStatements.php");
}

$query = "INSERT INTO `statements` (id, numberAuto, descriptionViolation, statusStatement, idUser, surname, userName, patronymic) VALUES (id = null, :numberAuto, :descriptionViolation, :statusStatement, :idUser, :surname, :userName, :patronymic)";
$stmt = $pdo->prepare($query);

if($stmt->execute([
    ":numberAuto" => $numberAuto,
    ":descriptionViolation" => $descriptionViolation,
    ":statusStatement" => $statusStatement,
    ":idUser" => $userId,
    ":surname" => $userSurname,
    ":userName" => $userName,
    ":patronymic" => $userPatronymic 
])) {
    $_SESSION['message'] = "Заявление добавлено";
    header("Location: ../statements.php");
} else {
    $_SESSION['message'] = "Произошла ошибка, побробуйте позже!";
}







?>