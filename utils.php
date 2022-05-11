<?php


    function dbInit(){
        $mysqli = new mysqli('localhost', "root","","flowerDB");
        if($mysqli->connect_errno){
            die($mysqli->connect_error);
        }
        $mysqli->query("set names utf8");


        return $mysqli;
    }

    function APIChecker(&$action, &$res){

        if(isset($_GET['action'])) {
            $action = $_GET['action'];
        }else{
            $res['error'] = true;
            $res ["message"] = "Not supported interface";
        }
    }

    function msgManager(&$res, $result){
        if($result){
            $res["message"] = "Operation Success";
        }else{
            $res ['error'] = true;
            $res ["message"] = "Operation Failed";
        }
    }

    function errorMsgManager(&$res, $msg){
        $res ['error'] = true;
        $res ["message"] = $msg;
    }

    function loginStatus(): bool
    {
        $user = false;
        $login_flag = false;
        mySessionStart();

        (isset($_SESSION["user"]) && $_SESSION["user"] === true)?$login_flag = true:$_SESSION["user"] = false;

        return $login_flag;
    }

    function adminStatus(): bool
    {
        $admin = false;
        $admin_flag = false;

        mySessionStart();

        (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)?$admin_flag = true:$_SESSION["admin"] = false;

        return $admin_flag;
    }


    function mySessionStart(){
        if(session_status() != PHP_SESSION_ACTIVE)session_start();
    }

?>

