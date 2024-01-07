<?php
require('logisticsModel.php');

$act = $_REQUEST['act'];

switch ($act)
{
    case "listOrder": //列出客戶訂單
        $jobs=getOrderList();
        echo json_encode($jobs);
        return; 
    case "markDelivered": //已送達
        $id = (int)$_REQUEST['id'];
        markOrderDelivered($id);
        break;
    case "markShipped": //已寄送
        $id = (int)$_REQUEST['id'];
        markOrderShipped($id);
        break;
    
    default:
}
?>
