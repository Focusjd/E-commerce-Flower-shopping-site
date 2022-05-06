<?php
require './utils.php';


    function main(){
        $mysqli = dbInit();
        $action = "";
        $res = array('error'=>false);
        APIChecker($action, $res);

        switch ($action){
            case "addCollect":
                addCollect($mysqli, $res);
                break;
            case "editCollect":
                editCollect($mysqli, $res);
                break;
            case "deleteCollect":
                deleteCollect($mysqli, $res);
                break;
            case "getUserCollects":
                getUserCollects($mysqli, $res);
                break;
            case "getCollectById":
                getCollectById($mysqli, $res);
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

    function getCollectById($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $id = $_POST['id'];
        $Q = "SELECT * FROM collect WHERE id = '$id'";
        $result = $mysqli->query($Q);

        if ($result) $res['collect'] = $result->fetch_assoc();

        msgManager($res,$result);
    }

    function getUserCollects($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $user_id = $_POST["user_id"];

        $Q = "SELECT * FROM collect WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

        $collects = array();
        while ($row = $result->fetch_assoc()){
            $collects[] = $row;
        }
        $res['charts'] = $collects;
        msgManager($res,$result);
    }

    function deleteCollect($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $id = $_POST['id'];
        $Q = "DELETE FROM collect WHERE id = '$id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function editCollect($mysqli, &$res)
    {
        errorMsgManager($res,"Not supported");
    }

    function addCollect($mysqli, &$res)
    {
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }

        $user_id = $_POST["user_id"];
        $product_id =  $_POST["product_id"];
        $collect_time = time();

        $Q = "INSERT INTO collect 
            (collect_time, user_id, product_id) 
            VALUES 
            ('$collect_time', '$user_id', '$product_id')";

        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    main();
?>

