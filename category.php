<?php
require './utils.php';


function main(){
    $mysqli = dbInit();
    $action = "";
    $res = array('error'=>false);
    APIChecker($action, $res);

    switch ($action){
        case "addCategory":
            addCategory($mysqli, $res);
            break;
        case "editCategory":
            editCategory($mysqli, $res);
            break;
        case "deleteCategory":
            deleteCategory($mysqli, $res);
            break;
        case "getCategories":
            getCategories($mysqli, $res);
            break;
        default:
            errorMsgManager($res, "Not supported interface");
    }

    $mysqli->close();
    header("Content-type:application/json");
    echo json_encode($res);
    die();
}

    function getCategories($mysqli, &$res)
    {
        $Q = "SELECT * FROM category";
        $result = $mysqli->query($Q);

        $categories = array();
        while ($row = $result->fetch_assoc()){
            $categories[] = $row;
        }
        $res['categories'] = $categories;
        msgManager($res,$result);
    }

    function deleteCategory($mysqli, &$res)
    {
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $category_id = $_POST['category_id'];
        $Q = "DELETE FROM category WHERE category_id = '$category_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function editCategory($mysqli, &$res)
    {
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $category_id = $_POST["category_id"];
        $category_name = $_POST["category_name"];

        $Q =
            "UPDATE category SET 
                category_name = '$category_name'
                WHERE category_id = '$category_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function addCategory($mysqli, &$res)
    {
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $category_name = $_POST["category_name"];

        $Q = "INSERT INTO category 
            (category_name) 
            VALUES 
            ('$category_name')";

        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }
    main();
?>

