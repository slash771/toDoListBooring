<?php
if(isset($_SESSION['sortBy'])){
$table = $pdo->query('SELECT * FROM `todolist` ORDER BY ' . $_SESSION['sortBy']);
}else{
echo "Coś, coś sie popsuło i nie było [...]";
}

foreach($table->fetchAll() as $toDoList){

echo  "<div>";
    echo  "<ul>";
        echo  "<li>";

            if($toDoList['cover']){
                echo '<img src="img/' . $toDoList['cover'] . '">';
            }

        echo  "</li>";
        echo  "</ul>";

    echo  "<ul>";
        echo  "<li>Zadanie:</li>";
        echo  "<li>Data wpisu:</li>";
        echo  "<li>Planowa data zakończenia:</li>";
        echo  "<li>Status:</li>";
        echo  "</ul>";

    echo  "<ul>";
        echo  "<li><span>" . $toDoList['zadanie'] ."</span></li>";
        echo  "<li>" . $toDoList['dataWpisu'] ."</li>";
        echo  "<li>" . $toDoList['dataZakonczenia'] ."</li>";
        echo  "<li>" . $toDoList['status'] ."</li>";
        echo  "</ul>";

    echo  "<ul>";
        echo  "<li>" . '<p><a href="index.php?id=' . $toDoList['id'].  '">Usuń Zadanie</a></p>' ."</li>";
        echo  "<li>" . '<p><a href="addEditGoal.php?id=' . $toDoList['id'].  '">Edytuj</a></p>' ."</li>";
        echo  "</ul>";
    echo  "</div>";
echo "<hr>";
}

?>