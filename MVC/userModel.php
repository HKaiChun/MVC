<?php
require("dbconfig.php");

function login($id, $username, $pwd,$role) {
	global $db;
	
	// Modify the SQL query to check both id and username
	$sql = "SELECT username FROM user WHERE  pwd=? AND role=?" ;
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "ssss",$username, $pwd,$role) ;

	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($loginr = mysqli_fetch_assoc($result)) {		
		return $loginr;
	} else {
		return 0;
	}
}

function register($username, $pwd, $role) {
    global $db;

    // 檢查用戶名是否已經存在
    $sql = "SELECT username FROM user WHERE pwd=? AND role=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "sss",$username, $pwd,$role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_fetch_assoc($result)) {
        // 如果用戶名已存在，返回錯誤代碼
        return ["result" => false, "message" => "Username already exists"];
    }

    // 使用 password_hash 對密碼進行加密
    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

    // 插入新用戶信息
    $sql = "INSERT INTO user (username, pwd, role) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $pwd, $role);
    
    if (mysqli_stmt_execute($stmt)) {
        return ["result" => true, "message" => "Registration successful"];
    } else {
        return ["result" => false, "message" => "Registration failed"];
    }
}

?>
