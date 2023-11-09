<?php

session_start();
require_once "./connect.php";

$statementID = $_POST['statementID'];
$statementChangeStatus = $_POST['status'];

$query = "UPDATE `statements` SET `statusStatement` = :statusStatement WHERE `statements`.`id` = :statementID";

$smtp = $pdo->prepare($query);

if ($statementChangeStatus === "подтвердить") {
    if ($smtp->execute([
        ":statusStatement" => "подтверждено",
        ":statementID" => $statementID
    ])) {

        // $_SESSION['message'] = "Статус заявления №$statementID обновлён!";
        header("Location: ../admin.php");
    } else {
        // $_SESSION['message'] = "Произошла ошибка, попробуйте позже!";
        header("Location: ../admin.php");
    }
}

if($statementChangeStatus === "отклонить") {
    if ($smtp->execute([
        ":statusStatement" => "отклонено",
        ":statementID" => $statementID
    ])) {

        $_SESSION['message'] = "Статус заявления №$statementID обновлён!";
        header("Location: ../admin.php");
    } else {
        $_SESSION['message'] = "Произошла ошибка, попробуйте позже!";
        header("Location: ../admin.php");
    }
}

?>
