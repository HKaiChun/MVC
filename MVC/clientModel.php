<?php
require('dbconfig.php');

function getJobList()
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

function getJobList1()
{
	global $db;
	$sql = "select * from shopping;";
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

function addJob($pName,$price,$description,$num)
{
	global $db;
    $total = $number*$price;
	$sql = "insert into shopping (pName, price, description, num, total) values (?, ?, ?, ?, ?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "sisii", $pName, $price,$description,$num,$total); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
function delJob($id)
{
	global $db;

	$sql = "delete from shopping where id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}

/*
function updateJob($id, $pName,$price,$description)
{
	global $db;

	$sql = "update list set pName=?, price=?, description=? where id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "sisi", $pName, $price,$description, $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
*/

?>