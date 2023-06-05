<?php
session_start();
//入力チェック（受信確認処理追加）
if(
    !isset($_POST["title"]) || $_POST["title"] == ""||
    !isset($_POST["body"]) || $_POST["body"] == ""
){
    exit('ParamError');
}

// 1. POSTデータ所得
$title = $_POST["title"];
$body = $_POST["body"];
$user_id_id = $_SESSION["user_id_id"];
$name = $_SESSION["name"];
$fname = $_SESSION["fname"];

// // 2.DB接続(エラー処理追加)
try{
    $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root','');
} catch(PDOException $e){
    exit('DbConnectError:'.$e->getMessage());
}

// // 3. データ登録SQL作成
$sql = "INSERT INTO articles(id, user_id_id, name, prof_img_name, title, body, created_at, updated_at)
VALUES(Null, :a1, :a2, :a3, :a4, :a5, sysdate(), sysdate())";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":a1", $user_id_id, PDO::PARAM_INT);
$stmt->bindValue(":a2", $name, PDO::PARAM_STR);
$stmt->bindValue(":a3", $fname, PDO::PARAM_STR);
$stmt->bindValue(":a4", $title, PDO::PARAM_STR);
$stmt->bindValue(":a5", $body, PDO::PARAM_STR);
$status = $stmt->execute();

// // // 4. データ登録処理後
if($status == false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}else{
    // 5.home.phpへリダイレクト
    header("Location: home.php");
    exit;
}





















?>