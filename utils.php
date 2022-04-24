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
        $admin = false;
        $login_flag = false;
        session_start();

        (isset($_SESSION["admin"]) && $_SESSION["admin"] === true)?$login_flag = true:$_SESSION["admin"] = false;

        return $login_flag;
    }


    function sessionStart(){
        //  启动 Session
        session_start();
        //  声明一个名为 admin 的变量，并赋空值。
        $_SESSION["admin"] = null;
    }

?>

