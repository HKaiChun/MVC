<?php
// 引入商戶模型
require('Merchantmodel.php');

// 從請求中獲取類型
$act = $_REQUEST['act'];

// 根據操作類型執行相應的操作
switch ($act) {
    case "listJob":
        // 獲取商品列表操作
        $account = $_REQUEST['account'];
        $jobs = getJobList($account);
        echo json_encode($jobs);
        return;

    case "gOrder":
        // 獲取訂單列表操作
        $account = $_REQUEST['account'];
        $jobs = getOrderList($account);
        echo json_encode($jobs);
        return;

    case "addJob":
        // 新增商品操作
        $account = $_REQUEST['account'];
        $jsonStr = $_POST['dat'];
        $job = json_decode($jsonStr);
        addJob($job->name, $job->price, $job->content, $account);
        return;

    case "updateJob":
        // 更新商品操作
        $id = (int)$_REQUEST['id'];
        $jsonStr = $_POST['dat'];
        $job = json_decode($jsonStr);
        updateJob($id, $job->name, $job->price, $job->content);
        return;

    case "delJob":
        // 刪除商品操作
        $id = (int)$_REQUEST['id'];
        // 驗證
        delJob($id);
        return;

    case "register1":
        // 將訂單狀態登記為處理中
        $id = (int)$_REQUEST['id'];
        toregister1($id);
        break;

    case "register2":
        // 將訂單狀態登記為寄送中
        $id = (int)$_REQUEST['id'];
        toregister2($id);
        break;

    default:
        // 預設
}

?>
