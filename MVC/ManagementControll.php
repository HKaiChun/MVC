<?php
require('ManagementModel.php');
$act = $_REQUEST['act'];

switch($act) {
    case "sendTransit":
        $proStr=$_POST['dat'];
        $pro=json_decode($proStr);
        sendTransit($pro->username); // 將購物車訂單移向訂單狀態表格(結帳動作)
        echo json_encode($pro);
        return;
    case "listTransit":
        $pro=getTransit();
        echo json_encode($pro);
        return;
    case "listPro":
        $pro=getLoadList();
        echo json_encode($pro);
        return;
    case "addPro":
        $proStr=$_POST['dat'];// 從 POST 請求中獲取數據
        $pro=json_decode($proStr);
        addPro($pro->pName,$pro->description,$pro->price,$pro->id);//把原本預設的代碼換成加入的資料
        return;
    case "delPro":
        $id=(int)$_REQUEST['id'];
        delPro($id);//刪除指定id
        return;
    case "addnum":
        $proStr=$_POST['dat'];//從post中獲取資料
        $pro=json_decode($proStr);
        addnum($pro->pName, $pro->description,$pro->price,$pro->num,$pro->total,$pro->id);//把原本預設的代碼換成加入的資料
        return;
    case "listshopping":
        $proStr=$_POST['dat'];
        $pro1=json_decode($proStr);
        $pro=getJobList1($pro1->username);
        echo json_encode($pro);
        return;
    case "addJob":
        $proStr = $_POST['dat'];
        $pro = json_decode($proStr);
        //should verify first
        addJob($pro->pName,$pro->price,$pro->description,$pro->num,$pro->id,$pro->username); //紀錄加入的工作
        return;
    case "delJob":
        $id=(int)$_REQUEST['id']; //$_GET, $_REQUEST //獲取需要刪除id
        //verify
        delJob($id);
        return;
    case "countP":
        $proStr=$_POST['dat'];
        $pro=json_decode($proStr);
        $totalP=countTotalP($pro->username);
        echo $totalP;
        return;
    default;

}
?>