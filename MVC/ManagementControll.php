<?php
require('ManagementModel.php');
$act = $_REQUEST['act'];

switch($act) {
    case "listPro":
        $pro=getLoadList();
        echo json_encode($pro);
        return;
    case "addPro":
        $proStr=$_POST['dat'];
        $pro=json_decode($proStr);
        addPro($pro->pName,$pro->description,$pro->price,$pro->id);
        return;
    case "delPro":
        $id=(int)$_REQUEST['id'];
        delPro($id);
        return;
    case "addnum":
        $proStr=$_POST['dat'];
        $pro=json_decode($proStr);
        addnum($pro->pName, $pro->description,$pro->price,$pro->num,$pro->total,$pro->id);
        return;
    case "listshopping":
        $pro=getJobList1();
        echo json_encode($pro);
        return;

    default;
}
?>