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
function delPro($id) {
    global $db;
    $sql = "delete from products where id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
	$stmt = mysqli_prepare($db, $sql); //prepare sql statement
	mysqli_stmt_bind_param($stmt, "i", $id); //bind parameters with variables, with types "sss":string, string ,string
	mysqli_stmt_execute($stmt);  //執行SQL
	return True;
}
// function updateJob($id, $pName,$description,$price) {
// 	echo $id, $pName,$description,$price;
// 	return;
// }
?>