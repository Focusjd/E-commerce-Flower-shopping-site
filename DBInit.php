<?php


    $_sql = file_get_contents('createDB.sql');
    $_arr = explode(';',$_sql);
    $mysqli = new mysqli('localhost', "root","","flowerDB");
    if($mysqli->connect_errno){
        die($mysqli->connect_error);
    }

    foreach ($_arr as $_value){
        $mysqli->query($_value.';');
    }
    $mysqli->close();
    echo "The database has initialized. "
?>