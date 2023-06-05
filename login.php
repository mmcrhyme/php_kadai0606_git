<?php
session_start();
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];


// 1.接続します
try{
    $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root','');
} catch(PDOException $e){
    exit('DbConnectError:'.$e->getMessage());
}

// 2. データ登録SQL作成
$sql = "SELECT * FROM users WHERE user_id = :a1 AND password = :a2";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(":a1", $lid);
$stmt->bindValue(":a2", $lpw);
$res = $stmt->execute();

// SQL実行時にエラーがある場合
if($res == false){ 
    $error = $stmt->errorInfo();
    exit("QueryError:".$error[2]);
}

//3. 抽出データ数を取得
$val = $stmt -> fetch();

// 4. 該当レコードがあればSESSIONに値を代入
if($val["id"] != ""){
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["user_id_id"] = $val["id"];
    $_SESSION["user_id"] = $val["user_id"];
    $_SESSION["name"] = $val["name"];
    $_SESSION["fname"] = $val["prof_img_name"];
    if(is_null($val['bio'])){
        $b = "bioはまだ設定されておりません。";
        $stm = $pdo->prepare("UPDATE users SET bio = :bio");
        $stm->bindValue(':bio', $b, PDO::PARAM_STR);

        $status = $stm->execute();
    
    if ($status == false) {
        $error = $stm->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }
    }
    if(is_null($val['admin'])){
        $a = 0;
        $stm = $pdo->prepare("UPDATE users SET admin = :admin");
        $stm->bindValue(':admin', $a, PDO::PARAM_STR);

        $status = $stm->execute();
    
    if ($status == false) {
        $error = $stm->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }
    }
    $_SESSION["bio"] = $val['bio'];
    $_SESSION["admin"] = $val['admin'];
    // Login処理OKの場合、home.phpへ遷移
    header ("Location: home.php");
}else{
    header ("Location: first.php");
}
// 処理終了
exit();

?>