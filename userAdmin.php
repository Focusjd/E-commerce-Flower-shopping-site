<?php
    require './utils.php';

    $mysqli = dbInit();
    $action = "";
    $res = array('error'=>false);
    APIChecker($action, $res);



    switch ($action){
        case "getAllUsers":
            getAllUsers($mysqli, $res);
            break;
        case "addUser":
            addUser($mysqli, $res);
            break;
        case "editUser":
            editUser($mysqli, $res);
            break;
        case "deleteUser":
            deleteUser($mysqli, $res);
            break;
        default:
            errorMsgManager($res, "Not supported interface");
    }


    function getAllUsers($mysqli, &$res){
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $Q = "SELECT * FROM users";
        $result = $mysqli->query($Q);

        $users = array();
        while ($row = $result->fetch_assoc()){
            array_push($users,$row);
        }
        $res['users'] = $users;
    }


    function addUser($mysqli, &$res){
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $Q = "INSERT INTO users (username, password, useremail) VALUES ('$username', '$password', '$email')";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }


    function editUser($mysqli, &$res){
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
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

    function deleteUser($mysqli, &$res){
        if(!adminStatus()){
            errorMsgManager($res, "Permission Deny, Admin Login Required.");
            return;
        }
        $user_id = $_POST['user_id'];
        $Q = "DELETE FROM users  WHERE user_id = '$user_id'";
        $result = $mysqli->query($Q);

        msgManager($res,$result);
    }


    $mysqli->close();
    header("Content-type:application/json");
    echo json_encode($res);
    die();
?>