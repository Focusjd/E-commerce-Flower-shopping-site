<?php
    require './utils.php';


    function main(){
        $mysqli = dbInit();
        $action = "";
        $res = array('error'=>false);
        APIChecker($action, $res);


        switch ($action){
            case "userLogin":
                userLogin($mysqli, $res);
                break;
            case "userLogout":
                userLogout($res);
                break;
            case "userLoginChecker":
                userLoginChecker($res);
                break;
            case "getUserInfoById":
                getUserInfoById($mysqli,$res);
                break;
            default:
                errorMsgManager($res, "Not supported interface");
        }


        $mysqli->close();
        header("Content-type:application/json");
        echo json_encode($res);
        die();
    }







    main();
?>

