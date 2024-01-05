<?php
require 'model.php';

$action = $_POST['action'];

if ($action === 'login') {
     $username = $_POST['username'];
     $pwd = $_POST['pwd'];
    
     $model = new UserModel();
     $user = $model->getUserByUsername($username);
    
     if ($user && pwd_verify($pwd, $user['pwd'])) {
         // 登入成功，跳到購物頁面
         echo '登入成功！ ';
     } else {
         echo '登入失敗，請檢查使用者名稱和密碼。 ';
     }
} elseif ($action === 'register') {
     $username = $_POST['username'];
     $pwd = pwd_hash($_POST['pwd'], pwd_DEFAULT);
    
     $model = new UserModel();
    
     if ($model->getUserByUsername($username)) {
         echo '使用者名稱已存在，請選擇其他使用者名稱。 ';
     } else {
         $model->insertUser($username, $pwd);
         echo '註冊成功！ ';
     }
}
?>