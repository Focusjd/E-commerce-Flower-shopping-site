<?php
    require './utils.php';

    function main(){
        $mysqli = dbInit();
        $action = "";
        $res = array('error'=>false);
        APIChecker($action, $res);


        switch ($action){
            case "userRegister":
                userRegister($mysqli, $res);
                break;
            case "editUserInfo":
                editUserInfo($mysqli, $res);
                break;
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
            case "adminLogin":
                adminLogin($mysqli,$res);
                break;
            case "adminLoginChecker":
                adminLoginChecker($res);
                break;
            case "adminLogout":
                adminLogout($res);
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

    function adminLogin($mysqli, &$res)
    {
        $password = $_POST["password"];
        $username = $_POST["username"];

        $Q = "SELECT * FROM admin WHERE `password` = '$password' AND `username` = '$username'";
        $result = $mysqli->query($Q);


        if ($result->num_rows>0) {
            session_start();
            $_SESSION["admin"] = true;

            $lifeTime = 5 * 3600;

            setcookie(session_name(), session_id(), time() + $lifeTime, "/");

            msgManager($res,true);
            $res['login_admin'] = $result->fetch_assoc();
        } else {
            $msg = "Wrong username password matching";
            errorMsgManager($res, $msg);
        }
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
            $_SESSION["user"] = true;
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
        unset($_SESSION['user']);
        session_destroy();
        msgManager($res,true);
    }

    function adminLogout(&$res){
        session_start();
        unset($_SESSION['admin']);
        session_destroy();
        msgManager($res,true);
    }

    function userLoginChecker(&$res){
        loginStatus()?msgManager($res,true):errorMsgManager($res, "Permission Deny, User Login Required.");
    }
    function adminLoginChecker(&$res){
        adminStatus()?msgManager($res,true):errorMsgManager($res, "Permission Deny, Admin Login Required.");
    }


    function getUserInfoById($mysqli, &$res){
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
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

    function userRegister($mysqli, &$res){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $Q = "INSERT INTO users (username, password, useremail) VALUES ('$username', '$password', '$email')";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }


    function editUserInfo($mysqli, &$res){
        if(!loginStatus()){
            errorMsgManager($res, "Permission Deny, User Login Required.");
            return;
        }
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $Q = "UPDATE users SET username = '$username', password = '$password', useremail = '$email' WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }
    main();
?>

