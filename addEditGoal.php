<?php
require_once('connection.php');
require_once('session.php');
require_once('headerLayout.php');
require_once('mainStartLayout.php');

if(isset($_POST['zadanie'])){

$id = isset( $_POST['id']) ? intval($_POST['id']) : 0;

$fileName = 0;

if(isset($_FILES['cover']['error']) && $_FILES['cover']['error'] == 0){

        require("vendor/autoload.php");

    $uid = uniqid();

    $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);

    $fileName = 'cover' . $uid . '.' . $ext;

    $imagine = new Imagine\Gd\Imagine();
    $size    = new Imagine\Image\Box(160, 110);
    $mode    = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

    $imagine->open($_FILES['cover']['tmp_name'])
            ->thumbnail($size, $mode)
            ->save(__DIR__ . '/img/' . $fileName);


    }



if($id > 0 ) {

    if($fileName){
        $queryStatement = $pdo->prepare('UPDATE `todolist` SET `zadanie`=:zadanie,`dataZakonczenia`=:dataZakonczenia, `status`=:status, `cover`=:cover WHERE id = :id' );
        $queryStatement->bindParam(':cover', $fileName);

        $queryStatementCover = $pdo->prepare('SELECT * FROM `todolist` WHERE id= :id');
        $queryStatementCover->bindParam(':id', $id);
        $queryStatementCover->execute();

        $cover = $queryStatementCover->fetch()['cover'];

        if($cover){
            unlink(__DIR__ . 'img/' . $cover);
        }

    }else{
        $queryStatement = $pdo->prepare('UPDATE `todolist` SET `zadanie`=:zadanie,`dataZakonczenia`=:dataZakonczenia, `status`=:status WHERE id = :id' );
    }


$queryStatement->bindParam(':id', $id);

}else{
$queryStatement = $pdo->prepare('INSERT INTO `todolist`(`zadanie`,`dataZakonczenia`, `status`, `cover`) VALUES (:zadanie,:dataZakonczenia, :status, :cover)');
    if($fileName){
        $queryStatement->bindParam(':cover', $fileName);
    }
}


$queryStatement->bindParam(':zadanie', $_POST['zadanie']);
$queryStatement->bindParam(':dataZakonczenia', $_POST['dataZakonczenia']);
$queryStatement->bindParam(':status', $_POST['status']);
$queryStatement->execute();

}

$idGet = isset( $_GET['id']) ? intval($_GET['id']) : 0;
if($idGet > 0 ) {

    $queryStatement = $pdo->prepare('SELECT * FROM `todolist` WHERE id= :id');
    $queryStatement->bindParam(':id', $idGet);
    $queryStatement->execute();

    $beforeEditResults = $queryStatement->fetch();

}

?>


<form method="post" action="addEditGoal.php" enctype="multipart/form-data">

    <?php

    if($idGet > 0){
        echo '<input type="hidden" name="id" value="' . $idGet . '">';
    }
    ?>



Zadanie: <input type="text" name="zadanie" <?php if(isset($beforeEditResults['zadanie'])){echo 'value="' . $beforeEditResults['zadanie'] . '"'; } ?>></br>

Miniaturka: <input type="file" name="cover" >
    <?php
    if(isset($beforeEditResults['cover']) && $beforeEditResults['cover']){
        echo '<img src="img/' . $beforeEditResults['cover'] . '">';
    }
    ?>

Planowa data zakończenia: <input type="datetime-local" name="dataZakonczenia" <?php if(isset($beforeEditResults['dataZakonczenia'])){
    $dataZakonczenia = $beforeEditResults['dataZakonczenia'];
    $dataZakonczenia = strtotime($dataZakonczenia);
    $dataZakonczenia = date("Y-m-d\TH:i", $dataZakonczenia);
    echo 'value="';
    echo $dataZakonczenia;
    echo '"';}
?>></br>



<?php if(isset($beforeEditResults['dataWpisu'])){echo "Data wpisu: <time>";if(isset($beforeEditResults['dataWpisu'])){echo $beforeEditResults['dataWpisu'];};echo "</time></br>";}?>

Status: <select class="form-control" name="status" >
    <option selected value="W trakcie">W trakcie</option>
    <option value="Zakończono">Zakończono</option>
    <option value="Porzucono">Porzucono</option>
</select></br>
<input type="submit" value="Zapisz" name="submit">
    <?php
    if(isset($_POST['submit'])){
        // MySQL stuff goes here
        header("Location: index.php");
        exit;
    }
    ?>
<a href="index.php"><input type="button" value="Powrót"></a>


</form>

<?php
require_once('mainEndLayout.php');
?>