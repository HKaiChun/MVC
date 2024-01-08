<?php
require('dbconfig.php');

// 獲取商品列表
function getJobList($account) {
    global $db;
    $sql = "SELECT * FROM products;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $account);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// 獲取訂單列表
function getOrderList($account) {
    global $db;
    $sql = "SELECT * FROM `order` WHERE Mid = ?;";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $account);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// 新增商品
function addJob($name, $price, $content, $account) {
    global $db;

    $sql = "INSERT INTO shop (name, price, content, Mid) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "siss", $name, $price, $content, $account);
    mysqli_stmt_execute($stmt);

    return true;
}

// 更新商品
function updateJob($id, $name, $price, $content) {
    global $db;

    $sql = "UPDATE shop SET name=?, price=?, content=? WHERE id=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "sisi", $name, $price, $content, $id);
    mysqli_stmt_execute($stmt);

    return true;
}

// 刪除商品
function delJob($id) {
    global $db;

    $sql = "DELETE FROM shop WHERE id=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    return true;
}

// 將訂單狀態登記為處理中
function toregister1($id) {
    global $db;

    $sql = "SELECT status FROM `order` WHERE id=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $rows = $row['status'];
    }

    if ($rows == '未處理') {
        $status = '處理中';
        $updateSql = "UPDATE `order` SET status=? WHERE id=?";
        $updateStmt = mysqli_prepare($db, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "si", $status, $id);
        mysqli_stmt_execute($updateStmt);
    }

    return true;
}

// 將訂單狀態登記為寄送中
function toregister2($id) {
    global $db;

    $sql = "SELECT status FROM `order` WHERE id=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $rows = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $rows = $row['status'];
    }

    if ($rows == '處理中') {
        $status = '寄送中';
        $updateSql = "UPDATE `order` SET status=? WHERE id=?";
        $updateStmt = mysqli_prepare($db, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "si", $status, $id);
        mysqli_stmt_execute($updateStmt);
    }

    return true;
}
?>
