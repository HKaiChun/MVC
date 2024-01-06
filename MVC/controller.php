<?php
require 'model.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱

if ($action === 'login') {
      $username = $_POST['username'];
      $password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
    
      $model = new UserModel();
      $user = $model->getUserByUsername($username);
    
      if ($user && password_verify($password, $user['password'])) {
          // 登入成功，跳到購物頁面
          $url = "http://localhost/MVC/MVC/clientView.html";
          echo "<script type='text/javascript'>";
          echo "window.location.href='$url'";
          echo "</script>";
                   }
     else{
          echo '登錄失敗，請檢查使用者名稱和密碼。 ';
     }
} elseif ($action === 'register') {
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 使用 "password" 作為表單欄位的名稱
    
      $model = new UserModel();
    
      if ($model->getUserByUsername($username)) {
          echo '使用者名稱已存在，請選擇其他使用者名稱。 ';
      } else {
          $model->insertUser($username, $password);
          header("Location: http://localhost/MVC/MVC/login.html?message=登入成功！");
          exit();
                }
}
?>