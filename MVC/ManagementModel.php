<?php
require('dbconfig.php');
function inTransit($id) {
	global $db;
	// 先檢查是否已經是 '已送達' 或 '已寄送' 狀態，是的話就不進行更新
	$currentStatus = getCurrentStatus($id);
	if ($currentStatus !== '已送達' && $currentStatus !=='已寄送') {
		$status='寄送中';
		$sql = "UPDATE `transit` SET status=? WHERE id=?";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_bind_param($stmt, "si", $status, $id);
		mysqli_stmt_execute($stmt);
		return true;
	}
	return false; // 如果已經是 '已送達'，返回 false 表示更新失敗
}
function getCurrentStatus($id) {
	global $db;
	$sql = "SELECT status FROM `transit` WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if (!$stmt) {
        die('SQL 錯誤: ' . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (!mysqli_stmt_execute($stmt)) {
        die('執行 SQL 錯誤: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_bind_result($stmt, $status);

    if (mysqli_stmt_fetch($stmt)) {
        return $status;
    }

    return null;
}
function getDone($username) {
	global $db;
	$sql = "select * from transit where username=? and status='已送達'";
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果
	$rows = array(); //要回傳的陣列
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r; //將此筆資料新增到陣列中
    }
    return $rows;
}
function sendTransit($username) {
	global $db;
	$sql = "INSERT INTO transit (pName, price, num, total, username, status) SELECT pName, price, num, total, username, '未處理' FROM shop WHERE username = ?;";
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt); //執行SQL
	
	$sql = "delete from shop where username=?";
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt); //執行SQL

	return true;
}
function getTransit($username) {
	global $db;
	$sql = "select * from transit where username=?;";
	$stmt = mysqli_prepare($db, $sql); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt); //執行SQL
    $result = mysqli_stmt_get_result($stmt); //取得查詢結果

    $rows = array(); //要回傳的陣列
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r; //將此筆資料新增到陣列中
    }
    return $rows;
}
function getTransitorder() {
	global $db;
	$sql = "select * from transit;";
	$stmt = mysqli_prepare($db, $sql); //precompile sql指令，建立statement 物件，以便執行SQL
    mysqli_stmt_execute($stmt); //執行SQL
    $result = mysqli_stmt_get_result($stmt); //取得查詢結果

    $rows = array(); //要回傳的陣列
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r; //將此筆資料新增到陣列中
    }
    return $rows;
}

function getLoadList()
{
    global $db;
    $sql = "select * from products;";
    $stmt = mysqli_prepare($db, $sql); //precompile sql指令，建立statement 物件，以便執行SQL
    mysqli_stmt_execute($stmt); //執行SQL
    $result = mysqli_stmt_get_result($stmt); //取得查詢結果

    $rows = array(); //要回傳的陣列
    while ($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r; //將此筆資料新增到陣列中
    }
    return $rows;
}
function getJobList1($username) // 列出購物車項目
{
	global $db;
	$sql = "select * from shop where username =?;";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt); //執行SQL
	$result = mysqli_stmt_get_result($stmt); //取得查詢結果

	$rows = array(); //要回傳的陣列
	while($r = mysqli_fetch_assoc($result))
	{
		$rows[] = $r; //將此筆資料新增到陣列中
	}
	return $rows;
}
function addPro($pName, $description, $price,$id) {
    global $db;
    if($id>0) {
		$sql = "update products set pName=?, description=?, price=? where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
		$stmt = mysqli_prepare($db, $sql); //prepare sql statement
		mysqli_stmt_bind_param($stmt, "ssii", $pName, $description,$price,$id); //bind parameters with variables, with types "sss":string, string ,string
	} else {
		$sql = "insert into products (pName, description, price) values (?, ?, ?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
		$stmt = mysqli_prepare($db, $sql); //prepare sql statement
		mysqli_stmt_bind_param($stmt, "ssi", $pName, $description,$price); //bind parameters with variables, with types "sss":string, string ,string
	}
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
function addnum($pName, $description,$price,$num,$total,$id){
    global $db;
    if($id>0) {
		$sql = "update products set pName=?, description=?, price=? ,num=?,total=?, where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
		$stmt = mysqli_prepare($db, $sql); //prepare sql statement
		mysqli_stmt_bind_param($stmt, "ssiiii", $pName, $description,$price,$num,$total,$id); //bind parameters with variables, with types "sss":string, string ,string
	} else {
		$sql = "insert into products (pName, description, price,num,total) values (?, ?,?,?,?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
		$stmt = mysqli_prepare($db, $sql); //prepare sql statement
		mysqli_stmt_bind_param($stmt, "ssiii", $pName, $description,$price,$num,$total); //bind parameters with variables, with types "sss":string, string ,string
	}
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
function delPro($id) {
    global $db;
    $sql = "delete from products where id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
function delJob($id)
{
	global $db;

	$sql = "delete from shop where id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
function addJob($pName,$price,$description,$num,$id,$username)
{
	global $db;
    $total = $num*$price;
	// 检查是否存在相同 id 的记录
    $checkSql = "SELECT COUNT(*) FROM shop WHERE id = ? AND username = ?";
    $checkStmt = mysqli_prepare($db, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "is", $id, $username);
    mysqli_stmt_execute($checkStmt);
    
    mysqli_stmt_bind_result($checkStmt, $count);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

	// 如果存在相同 id 、使用者的紀錄
	if ($count > 0) {
		$sql = "update shop set total = total + ?, num = num + ? where id = ? AND username = ?";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_bind_param($stmt, "iiis", $total, $num, $id, $username);
		mysqli_stmt_execute($stmt);
		return true;
	} else {
		$sql = "insert into shop (pName, price,description,num, total, id, username) values (?, ?, ?, ?, ?, ?, ?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
		$stmt = mysqli_prepare($db, $sql); //prepare sql statement
		mysqli_stmt_bind_param($stmt, "sisiiis", $pName, $price,$description,$num,$total,$id,$username); //bind parameters with variables, with types "sss":string, string ,string
		mysqli_stmt_execute($stmt);  //執行SQL
		return True;
	}
}
function countTotalP($username)
{
	global $db;
	$sql = "select sum(total) as totalSum FROM `shop` where username=?";
	$stmt = mysqli_prepare($db, $sql);
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	
	$result = mysqli_stmt_get_result($stmt);
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		return $row['totalSum'];
	} else {
		// 錯誤處理
		return false;
	}
}
// function updateJob($id, $pName,$description,$price) {
// 	echo $id, $pName,$description,$price;
// 	return;
// }
?>