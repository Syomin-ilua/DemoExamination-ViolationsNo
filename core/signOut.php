<?php

session_start();

$userID = $_POST['userID'];

if(empty($userID)) {
    header("Location: ../statements.php");
}

session_destroy();

header("Location: ../login.php");

?>