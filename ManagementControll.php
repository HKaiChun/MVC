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
    default;
}
?>