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

    function userLogin($mysqli, &$res){
        $password = $_POST["password"];
        $username = $_POST["username"];

        $Q = "SELECT * FROM `users` WHERE `password` = '$password' AND `username` = '$username'";
        $result = $mysqli->query($Q);

//        var_dump($result);
//        print_r($result);
//        $users = array();
//
//        while ($row = $result->fetch_assoc()){
//            $users[] = $row;
//        }
//        $res['users'] = $users;

        if ($result->num_rows>0) {
            session_start();
            $_SESSION["admin"] = true;
            //  保存一天
            $lifeTime = 24 * 3600;

            setcookie(session_name(), session_id(), time() + $lifeTime, "/");

            msgManager($res,true);
            $res['login_user'] = $result->fetch_assoc();
        } else {
            $msg = "Wrong username password matching";
            errorMsgManager($res, $msg);
        }
    }

    function userLogout(&$res){
        session_start();
        unset($_SESSION['admin']);
        session_destroy();
        msgManager($res,true);
    }

    function userLoginChecker(&$res){
        loginStatus()?msgManager($res,true):errorMsgManager($res, "Permission Deny, Login Required.");
    }

    function loginStatus(){
        $admin = false;
        $login_flag = false;
        session_start();

        (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)?$login_flag = true:$_SESSION["admin"] = false;

        return $login_flag;
    }


    function getUserInfoById($mysqli, &$res){
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, Login Required.");
            return;
        }
        $user_id = $_POST['user_id'];
        $Q = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

//        $users = array();
//        while ($row = $result->fetch_assoc()){
//            $users[] = $row;
//        }
//        $res['users'] = $users;

        msgManager($res,$result);
        if ($result) $res['user_info'] = $result->fetch_assoc();
    }


    main();
?>

