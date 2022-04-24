<?php
require './utils.php';


function main(){
    $mysqli = dbInit();
    $action = "";
    $res = array('error'=>false);
    APIChecker($action, $res);


    switch ($action){
        case "getAllProducts":
            getAllProducts($mysqli, $res);
            break;
        case "getProductById":
            getProductById($mysqli, $res);
            break;
        case "addProduct":
            addProduct($mysqli, $res);
            break;
        case "editProduct":
            editProduct($mysqli, $res);
            break;
        case "deleteProduct":
            deleteProduct($mysqli, $res);
            break;
        case "searchProductByName":
            searchProductByName($mysqli, $res);
            break;
        case "getProductByCategory":
            getProductByCategory($mysqli, $res);
            break;
        default:
            errorMsgManager($res, "Not supported interface");
    }


    $mysqli->close();
    header("Content-type:application/json");
    echo json_encode($res);
    die();
}

    function getProductByCategory($mysqli, &$res)
    {
        $category_id = $_POST['category_id'];
        $Q = "SELECT * FROM product WHERE category_id = '$category_id'";
        $result = $mysqli->query($Q);

        $products = array();
        while ($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        $res['products'] = $products;
        msgManager($res,$result);
    }

    function searchProductByName($mysqli, &$res)
    {
        $search_name = $_POST['$search_name'];
        $Q = "SELECT * FROM product WHERE product_name like '$search_name%'";
        $result = $mysqli->query($Q);

//        print_r($result->fetch_assoc());

        $products = array();
        while ($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        $res['products'] = $products;

        msgManager($res,$result);
    }

    function getProductById($mysqli, &$res)
    {
        $product_id = $_POST['product_id'];
        $Q = "SELECT * FROM product WHERE product_id = '$product_id'";
        $result = $mysqli->query($Q);

//        print_r($result->fetch_assoc());

        if ($result) $res['product_info'] = $result->fetch_assoc();

        msgManager($res,$result);
    }

    function deleteProduct($mysqli, &$res)
    {
        $product_id = $_POST['product_id'];
        $Q = "DELETE FROM product  WHERE product_id = '$product_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function editProduct($mysqli, &$res)
    {

        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $product_title = (isset($_POST['product_title']))?$_POST['product_title']:"";
        $product_intro = (isset($_POST['product_intro']))?$_POST['product_intro']:"";
        $product_picture = (isset($_POST['product_picture']))?$_POST['product_picture']:"";
        $product_price = (isset($_POST['product_price']))?$_POST['product_price']:-1;
        $product_selling_price = (isset($_POST['product_selling_price']))?$_POST['product_selling_price']:-1;
        $product_num = (isset($_POST['product_num']))?$_POST['product_num']:-1;
        $product_sales = (isset($_POST['product_sales']))?$_POST['product_sales']:-1;

//        $product_title = $_POST['product_title'];
//        $product_intro = $_POST['product_intro'];
//        $product_picture = $_POST['product_picture'];
//        $product_price = $_POST['product_price'];
//        $product_selling_price = $_POST['product_selling_price'];
//        $product_num = $_POST['product_num'];
//        $product_sales = $_POST['product_sales'];

        $Q =
            "UPDATE product SET 
            product_name = '$product_name', category_id = '$category_id', product_title = '$product_title', product_intro = '$product_intro', product_picture = '$product_picture', product_price = '$product_price', product_selling_price = '$product_selling_price', product_num = '$product_num', product_sales = '$product_sales'
            WHERE product_id = '$product_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }

    function addProduct($mysqli, &$res)
    {
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $product_title = (isset($_POST['product_title']))?$_POST['product_title']:"";
        $product_intro = (isset($_POST['product_intro']))?$_POST['product_intro']:"";
        $product_picture = (isset($_POST['product_picture']))?$_POST['product_picture']:"";
        $product_price = (isset($_POST['product_price']))?$_POST['product_price']:-1;
        $product_selling_price = (isset($_POST['product_selling_price']))?$_POST['product_selling_price']:-1;
        $product_num = (isset($_POST['product_num']))?$_POST['product_num']:-1;
        $product_sales = (isset($_POST['product_sales']))?$_POST['product_sales']:-1;

        $Q = "INSERT INTO product 
        (product_name, category_id, product_title, product_intro, product_picture, product_price, product_selling_price, product_num, product_sales) 
        VALUES 
        ('$product_name', '$category_id', '$product_title', '$product_intro', '$product_picture', '$product_price', '$product_selling_price', '$product_num', '$product_sales')";

        $result = $mysqli->query($Q);
        msgManager($res,$result);
    }

    function getAllProducts($mysqli, &$res)
    {
        $Q = "SELECT * FROM product";
        $result = $mysqli->query($Q);

        $products = array();
        while ($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        $res['products'] = $products;
        msgManager($res,$result);
    }


main();
?>

