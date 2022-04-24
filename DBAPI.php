<?php



    $res = array('error'=>false);

    function updateData($sql){
        $mysqli = new mysqli('localhost', "root","","flowerDB");
        if($mysqli->connect_errno){
            die($mysqli->connect_error);
        }
        $mysqli->query("set names utf8");

        $result = $mysqli->query($sql);
        if ($result){
            echo "success";
        }else{
            echo  "failed";
        }
        $mysqli->close();

    }

     function fetchData($sql){
        $mysqli = new mysqli('localhost', "root","","flowerDB");
        if($mysqli->connect_errno){
            die($mysqli->connect_error);
        }
        $mysqli->query("set names utf8");

        $result = $mysqli->query($sql);
//            while ($row = $result->fetch_row()){
//                print_r($row);
//            }

        $row = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($row);

        $mysqli->close();
    }
//    echo rand(1000000000, 9999999999);
?>