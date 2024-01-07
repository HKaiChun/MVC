<?php
require('dbconfig.php');
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
function getJobList1()
{
	global $db;
	$sql = "select * from shop;";
	$stmt = mysqli_prepare($db, $sql ); //precompile sql指令，建立statement 物件，以便執行SQL
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
    $checkSql = "SELECT COUNT(*) FROM shop WHERE id = ?";
    $checkStmt = mysqli_prepare($db, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "i", $id);
    mysqli_stmt_execute($checkStmt);
    
    mysqli_stmt_bind_result($checkStmt, $count);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

	// 如果存在相同 id 的记录
	if ($count > 0) {
		$sql = "update shop set total = total + ?, num = num + ? where id = ?";
		$stmt = mysqli_prepare($db, $sql);
		mysqli_stmt_bind_param($stmt, "iii", $total, $num, $id);
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
function countTotalP()
{
	global $db;
	$sql = "select sum(total) as totalSum FROM `shop`";
	$stmt = mysqli_query($db, $sql);
	if ($stmt) {
		$row = mysqli_fetch_assoc($stmt);
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