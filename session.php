<?php

session_start();

if (isset($_POST['sortBy'])){
    $posted_data = $_POST['sortBy'];
    $_SESSION['sortBy'] = $posted_data;
}else{
    $defaultSortValue = 'dataZakonczenia';
    $_SESSION['sortBy'] = $defaultSortValue;
    $table = $pdo->query('SELECT * FROM `todolist` ORDER BY ' . $_SESSION['sortBy']);
}


if(isset($_POST['login'])){

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $queryStatement = $pdo->prepare('SELECT * FROM `users` WHERE login = :login AND password = :password');
    $queryStatement->bindParam(':login', $login, PDO::PARAM_STR);
    $queryStatement->bindParam(':password', $password, PDO::PARAM_STR);

    $queryStatement->execute();

    $loginPassResult = $queryStatement->fetch();

    if( $loginPassResult && isset( $loginPassResult['id'])){

        $_SESSION['logged'] = true;
        $_SESSION['userLogin'] = $loginPassResult['login'];
        header('location: index.php');
    }
}


require_once('headLayout.php');


if(!isset($_SESSION['logged']) || $_SESSION['logged'] == false){

    require_once ('loginLayout.php');
    die;
}

?>