<?php
    require './utils.php';


    function main(){
        $mysqli = dbInit();
        $action = "";
        $res = array('error'=>false);
        APIChecker($action, $res);

        switch ($action){
            case "getUserOrders":
                getUserOrders($mysqli, $res);
                break;
            case "getOrderById":
                getOrderById($mysqli, $res);
                break;
            case "createOrder":
                createOrder($mysqli, $res);
                break;
            case "editOrder":
                editOrder($mysqli, $res);
                break;
            case "deleteOrder":
                deleteOrder($mysqli, $res);
                break;
            case "getAllOrders":
                getAllOrders($mysqli, $res);
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

    function getAllOrders($mysqli, &$res){
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $Q = "SELECT * FROM orders";
        $result = $mysqli->query($Q);

        $orders = array();
        while ($row = $result->fetch_assoc()){
            array_push($orders, $row);
        }
        $res['orders'] = $orders;
    }


    function deleteOrder($mysqli, &$res)
    {
        if(!adminStatus()&&!loginStatus()){
            errorMsgManager($res, "Permission Deny, User or Admin Login Required.");
            return;
        }
        $order_id = $_POST['order_id'];
        $Q = "DELETE FROM orders  WHERE order_id = '$order_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function editOrder($mysqli, &$res)
    {
        if(!adminStatus()&&!loginStatus()){
            errorMsgManager($res, "Permission Deny, User or Admin Login Required.");
            return;
        }
        $order_id = $_POST["order_id"];
        $product_num = (isset($_POST['product_num']))?$_POST['product_num']:-1;
        $product_price = (isset($_POST['product_price']))?$_POST['product_price']:-1;
        $shipping_info = (isset($_POST['shipping_info']))?$_POST['shipping_info']:"";
        $payment_info = (isset($_POST['payment_info']))?$_POST['payment_info']:"";

        $Q =
            "UPDATE orders SET 
            product_num = '$product_num', product_price = '$product_price', shipping_info = '$shipping_info', payment_info = '$payment_info'
            WHERE order_id = '$order_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function createOrder($mysqli, &$res)
    {
        if(!adminStatus()&&!loginStatus()){
            errorMsgManager($res, "Permission Deny, User or Admin Login Required.");
            return;
        }
        $order_id = rand(1000000000, 9999999999);
        $user_id = $_POST["user_id"];
        $product_id =  $_POST["product_id"];
        $order_time = time();
        $product_num = (isset($_POST['product_num']))?$_POST['product_num']:-1;
        $product_price = (isset($_POST['product_price']))?$_POST['product_price']:-1;
        $shipping_info = (isset($_POST['shipping_info']))?$_POST['shipping_info']:"";
        $payment_info = (isset($_POST['payment_info']))?$_POST['payment_info']:"";

        $Q = "INSERT INTO orders 
        (order_id, user_id, product_id, order_time, product_num, product_price, shipping_info, payment_info) 
        VALUES 
        ('$order_id', '$user_id', '$product_id', '$order_time', '$product_num', '$product_price', '$shipping_info', '$payment_info')";

        $result = $mysqli->query($Q);
        msgManager($res,$result);
    }

    function getOrderById($mysqli, &$res)
    {
        if(!adminStatus()&&!loginStatus()){
            errorMsgManager($res, "Permission Deny, User or Admin Login Required.");
            return;
        }
        $order_id = $_POST['order_id'];
        $Q = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $result = $mysqli->query($Q);

        if ($result) $res['orders'] = $result->fetch_assoc();

        msgManager($res,$result);
    }

    function getUserOrders($mysqli, &$res)
    {
        if(!adminStatus()&&!loginStatus()){
            errorMsgManager($res, "Permission Deny, User or Admin Login Required.");
            return;
        }
        $user_id = $_POST["user_id"];

        $Q = "SELECT * FROM orders WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

        $orders = array();
        while ($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        $res['orders'] = $orders;
        msgManager($res,$result);
    }


    main();
?>

