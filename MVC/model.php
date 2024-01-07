<?php
require('dbconfig.php');
class UserModel {
    private $conn;

    
    public function __construct() {
        // 建立一個新的PDO（PHP資料物件）實例來建立資料庫連接
        // PDO是PHP用於存取資料庫的標準接口
        // 參數1: 資料庫的主機名稱與資料庫名，格式為 "mysql:host=主機名稱;dbname=資料庫名稱"
        
        $this->conn = new PDO("mysql:host=localhost;dbname=test", "root", "root");
   
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
    // 在 model.php 中添加编辑和删除商品的函数
    function getLoadList()
    {
        global $db;
        $sql = "select * from shipments;";
        $stmt = mysqli_prepare($db, $sql); // precompile SQL 指令
        mysqli_stmt_execute($stmt); // 执行 SQL
        $result = mysqli_stmt_get_result($stmt); // 取得查询结果

        $rows = array(); // 要返回的数组
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r; // 将此笔数据新增到数组中
        }
        return $rows;
    }

    function addPro($sender, $receiver, $status,$shipment_id) {
        global $db;
        if($shipment_id>0) {
            $sql = "update shipments set sender=?, receiver=?, status=? where shipment_id=?"; //SQL中的 ? 代表未來要用變數綁定進去的地方
            $stmt = mysqli_prepare($db, $sql); //prepare sql statement
            mysqli_stmt_bind_param($stmt, "sssi", $sender, $receiver,$status,$shipment_id); //bind parameters with variables, with types "sss":string, string ,string
        } else {
            $sql = "insert into shipments (sender, receiver, status) values (?, ?, ?)"; //SQL中的 ? 代表未來要用變數綁定進去的地方
            $stmt = mysqli_prepare($db, $sql); //prepare sql statement
            mysqli_stmt_bind_param($stmt, "sss", $sender, $receiver,$status); //bind parameters with variables, with types "sss":string, string ,string
        }
        mysqli_stmt_execute($stmt);  //執行SQL
        return True;
    }
    
    function delPro($shipment_id) {
        global $db;
        $sql = "delete from shipments where shipment_id=?;"; //SQL中的 ? 代表未來要用變數綁定進去的地方
        $stmt = mysqli_prepare($db, $sql); //prepare sql statement
        mysqli_stmt_bind_param($stmt, "i", $shipment_id); //bind parameters with variables, with types "sss":string, string ,string
        mysqli_stmt_execute($stmt);  //執行SQL
        return True;
    }
}
?>
