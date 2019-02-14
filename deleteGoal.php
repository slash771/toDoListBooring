<?php
$id = isset( $_GET['id']) ? intval($_GET['id']) : 0;

if($id > 0 ) {

    $queryStatementCover = $pdo->prepare('SELECT * FROM `todolist` WHERE id= :id');
    $queryStatementCover->bindParam(':id', $id);
    $queryStatementCover->execute();

    $cover = $queryStatementCover->fetch()['cover'];

    if($cover){
        unlink(__DIR__ . '/img/' . $cover);
    }


$queryStatement = $pdo->prepare('DELETE FROM `todolist` WHERE id= :id');
$queryStatement->bindParam(':id', $id);
$queryStatement->execute();

header('location: index.php');
}
?>