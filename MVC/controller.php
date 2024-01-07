<?php
require 'model.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
$user_type = $_POST['user_type'];

if ($action === 'login') {
      $username = $_POST['username'];
      $password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
      $user_type = $_POST['user_type'];
      $model = new UserModel();
      $user = $model->getUserByUsername($username);
      $userType = $model->getUser_type($username,$user_type);

      if ($user && password_verify($password, $user['password']) && $userType && $user_type=='client') {
        // 登入成功，跳到客户页面
        header("Location: http://localhost/MVC/MVC/clientView.html");
        setcookie($user_type, $username, time() + 3600, '/'); // Adjust the expiration time as needed
        exit();
    } elseif ($user && password_verify($password, $user['password']) && $userType && $user_type=='merchant') {
        // 登入成功，跳到商家页面
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
?>