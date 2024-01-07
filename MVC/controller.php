<?php
require 'model.php';

$action = $_POST['action'];
$username = $_POST['username'];
$password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
<<<<<<< HEAD
$role = $_POST['role'];

if ($action === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
    $role = $_POST['role'];

    $model = new UserModel();
    $user = $model->getUserByUsername($username);

    // 確認名字、身分無誤後才登入
    if ($user && password_verify($password, $user['password']) && $model->getUserRole($username, $role) && $role=='client') {
        // 登入成功，跳到購物頁面
        setcookie($role, $username, time() + 3600, '/'); // Adjust the expiration time as needed
        $url = "http://localhost/MVC/MVC/clientView.html";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    } else if ($user && password_verify($password, $user['password']) && $model->getUserRole($username, $role) && $role=='manager') {
        // 商家頁面
        $url = "http://localhost/MVC/MVC/ManagementView.html";
        echo "<script type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    } else {
        echo '登錄失敗，請檢查使用者名稱和密碼。 ';
    }
} elseif ($action === 'register') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 使用 "password" 作為表單欄位的名稱
    $role = $_POST['role'];

    $model = new UserModel();

    if ($model->getUserByUsername($username)) {
        echo '使用者名稱已存在，請選擇其他使用者名稱。 ';
    } else {
        $model->insertUser($username, $password, $role);
        header("Location: http://localhost/MVC/MVC/login.html?message=登入成功！");
        exit();
    }
=======
if ($action === 'login') {
      $username = $_POST['username'];
      $password = $_POST['password']; // 使用 "password" 作為表單欄位的名稱
      $user_type = $_POST['user_type'];
      $model = new UserModel();
      $user = $model->getUserByUsername($username);
      $user_type = $model->getUser_type($username);

      if ($user && password_verify($password, $user['password']) && $user_type === 'client') {
        // 登入成功，跳到客户页面
        header("Location: http://localhost/MVC/MVC/clientView.html");
        exit();
    } elseif ($user && password_verify($password, $user['password']) && $user_type === 'merchant') {
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
>>>>>>> 0f0020848e79040dc44406e0de0224253ea04c27
}
?>