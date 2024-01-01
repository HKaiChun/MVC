<?php
require("userModel.php");
header("Access-Control-Allow-Origin: http://localhost:8889");

$act = $_REQUEST['act'];
switch ($act) {
    case "login":
		//$id = $_REQUEST['id'];
		$username = $_REQUEST['username']; // 新增 username 參數
		$pwd = $_REQUEST['pwd'];
		$role = $_REQUEST['role'];
        $information = login( $username, $pwd,$role);
        setcookie('loginRole', $information); // Set the role in cookie

        if ($role > 0) {
            $msg = [
                "msg" => "OK",
                "role" => $information
            ];
        } else {
            $msg = [
                "msg" => "NO",
                "role" => 0
            ];
        }
        echo json_encode($msg);
        return;
        break;

    case 'showInfo':
        // Check if logged in
        $loginRole = $_COOKIE['loginRole'];
        if ($loginRole > 0) {
            $msg = "You've logged in. Your role is $loginRole.";
        } else {
            $msg = "You need to login to use this function.";
        }
        echo $msg;
        break;

    case 'logout':
        setcookie('loginRole', 0);
        break;

    case 'register':
        $username = $_REQUEST['username'];
        $pwd = $_REQUEST['pwd'];
        $role = $_REQUEST['role']; // New field for role
        $information = login( $username, $pwd,$role);
        // In userModel.php, implement a register function that inserts new user information into the database.
        $registrationResult = register($username, $pwd, $role);
        if ($registrationResult) {
            $msg = [
                "msg" => "Registration successful",
                "info" => $registrationResult
            ];
        } else {
            $msg = [
                "msg" => "Registration failed",
                "info" => 0
            ];
        }
        
        echo json_encode($msg);
        return;
        break;

    default:
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
}
?>
