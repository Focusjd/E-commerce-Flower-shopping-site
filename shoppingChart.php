<?php
    require './utils.php';


    function main(){
        $mysqli = dbInit();
        $action = "";
        $res = array('error'=>false);
        APIChecker($action, $res);

        switch ($action){
            case "addChart":
                addChart($mysqli, $res);
                break;
            case "editChart":
                editChart($mysqli, $res);
                break;
            case "deleteChart":
                deleteChart($mysqli, $res);
                break;
            case "getUserCharts":
                getUserCharts($mysqli, $res);
                break;
            case "getChartById":
                getChartById($mysqli, $res);
                break;
            default:
                errorMsgManager($res, "Not supported interface");
        }

        $mysqli->close();
        header('Access-Control-Allow-Origin:*');
        header("Content-type:application/json");
        echo json_encode($res);
        die();
    }

    function getChartById($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $id = $_POST['id'];
        $Q = "SELECT * FROM shoppingCart WHERE id = '$id'";
        $result = $mysqli->query($Q);

        if ($result) $res['charts'] = $result->fetch_assoc();

        msgManager($res,$result);
    }

    function getUserCharts($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $user_id = $_POST["user_id"];

        $Q = "SELECT * FROM shoppingCart WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

        $charts = array();
        while ($row = $result->fetch_assoc()){
            $charts[] = $row;
        }
        $res['charts'] = $charts;
        msgManager($res,$result);
    }

    function deleteChart($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $id = $_POST['id'];
        $Q = "DELETE FROM shoppingCart WHERE id = '$id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function editChart($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $id = $_POST["id"];
//        $user_id = $_POST["user_id"];
//        $product_id =  $_POST["product_id"];
        $num = $_POST["num"];

//        $Q =
//            "UPDATE shoppingCart SET
//            num = '$num', product_id = '$product_id', user_id = '$user_id'
//            WHERE id = '$id'";
        $Q =
            "UPDATE shoppingCart SET 
            num = '$num'
            WHERE id = '$id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function addChart($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }

        $user_id = $_POST["user_id"];
        $product_id =  $_POST["product_id"];
        $num = $_POST["num"];

        $Q = "INSERT INTO shoppingCart 
        (num, user_id, product_id) 
        VALUES 
        ('$num', '$user_id', '$product_id')";

        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    main();
?>

