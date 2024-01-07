<?php
class UserModel {
    private $conn;

    
    public function __construct() {
        // 建立一個新的PDO（PHP資料物件）實例來建立資料庫連接
        // PDO是PHP用於存取資料庫的標準接口
        // 參數1: 資料庫的主機名稱與資料庫名，格式為 "mysql:host=主機名稱;dbname=資料庫名稱"
        
        $this->conn = new PDO("mysql:host=localhost;dbname=test", "root", "");
   
        // 設定PDO的錯誤處理模式為拋出例外（Exception）
        // 這表示如果發生任何資料庫錯誤，PDO會拋出一個例外以供捕獲和處理
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUser_type($username,$user_type) {
        $stmt = $this->conn->prepare("SELECT user_type FROM user WHERE username = ? AND user_type=?");
        $stmt->execute([$username, $user_type]);
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function insertUser($username, $password,$user_type) {
        $stmt = $this->conn->prepare("INSERT INTO user (username, password,user_type) VALUES (?, ?,?)");
        $stmt->execute([$username, $password,$user_type]);
    }
}
?>
