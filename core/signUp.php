<?php

    session_start();
    require_once "connect.php";

    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $patronymic = $_POST["patronymic"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $userLogin = $_POST["login"];
    $userPassword = $_POST["password"];
    $role = "user";

    if(empty($surname) || empty($name) || empty($patronymic) || empty($tel) || empty($email) || empty($userLogin) || empty($userPassword)) {
        $_SESSION['message'] = "Поля не должны быть пустыми, пожайлуйста попробуйте ещё";
        header("Location: ../registration.php");
    }

    $query = "INSERT INTO `users` (id, surname, userName, patronymic, tel, email, userLogin, userPassword, userRole) VALUES (id = NULL, :surname, :userName, :patronymic, :tel, :email, :userLogin, :userPassword, :userRole)";
    $stmt = $pdo->prepare($query);

    if ($stmt->execute([
            ':surname' => $surname, 
            ':userName' => $name, 
            ':patronymic' => $patronymic, 
            ':tel' => $tel, ':email' => $email, 
            ':userLogin' => $userLogin, 
            ':userPassword' => $userPassword, 
            ':userRole' => $role])
        ) {
        // $_SESSION['message'] = "Регистрация прошла успешно! Пройдите авторизацию";
        header("Location: ../login.php");
    } else {
        $_SESSION['message'] = "Произошла ошибка, побробуйте позже!";
        header("Location: ../registration.php");
        // $errorInfo = $stmt->errorInfo();
        // echo "Ошибка выполнения запроса: " . $errorInfo[2];
    }

?>


