<?php
require 'model.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
if ($action === 'login') {
      $username = $_POST['username'];
      $password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
      $user_type = $_POST['user_type'];
      $model = new UserModel();
      $user = $model->getUserByUsername($username);
      $user_type = $model->getUser_type($username);

      if ($user && password_verify($password, $user['password']) && $user_type === 'client') {
        header("Location: http://localhost/MVC/MVC/clientView.html");
        exit();
    } elseif ($user && password_verify($password, $user['password']) && $user_type === 'merchant') {
        header("Location: http://localhost/MVC/MVC/ManagementView.html");
        exit();
    } else {
        echo '登錄失敗，請檢查使用者名稱和密碼或用戶類型。';
    } 
}
elseif ($action === 'register') {
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 使用 "password" 作為表單欄位的名稱
      $user_type = $_POST['user_type'];
      $model = new UserModel();
    
      if ($model->getUserByUsername($username)) {
          echo '使用者名稱已存在，請選擇其他使用者名稱。 ';
      } else {
          $model->insertUser($username, $password, $user_type);
          header("Location: http://localhost/MVC/MVC/login.html?message=註冊成功！");
          exit();
                }
}
$act = $_REQUEST['act'];
switch($act) {
    case "listPro":
        $pro=getLoadList();
        echo json_encode($pro);
        return;
    case "addPro":
        $proStr=$_POST['dat'];// 從 POST 請求中獲取數據
        $pro=json_decode($proStr);
        addPro($pro->sender,$pro->receiver,$pro->status,$pro->shipment_id);//把原本預設的代碼換成加入的資料
        return;
    case "delPro":
        $shipment_id=(int)$_REQUEST['shipment_id'];
        delPro($shipment_id);//刪除指定id
        return;
    /*
    case "addnum":
        $proStr=$_POST['dat'];//從post中獲取資料
        $pro=json_decode($proStr);
        addnum($pro->pName, $pro->description,$pro->price,$pro->num,$pro->total,$pro->id);//把原本預設的代碼換成加入的資料
        return;
    
    case "listshopping":
        $pro=getJobList1();
        echo json_encode($pro);
        return;
    */
    case "addJob":
        $proStr = $_POST['dat'];
        $pro = json_decode($proStr);
        //should verify first
        addJob($pro->sender,$pro->receiver,$pro->status,$pro->shipment_id); //紀錄加入的工作
        return;
    case "delJob":
        $shipment_id=(int)$_REQUEST['shipment_id']; //$_GET, $_REQUEST //獲取需要刪除id
        //verify
        delJob($shipment_id);
        return;
    /*
    case "countP":
        $totalP=countTotalP();
        echo $totalP;
        return;
    */
    default;
}
?>