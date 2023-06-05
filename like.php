<?php
try {
  // データベースに接続
  $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
  exit('DbConnectError:' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // POSTデータを取得
  $article_id = $_POST["article_id"];
  $user_id_id = $_POST["user_id_id"];

  // フォローデータをデータベースに挿入
  $stmt = $pdo->prepare("INSERT INTO likes (user_id, article_id, comment_id, created_at, updated_at)
                        VALUES (:user_id_id, :article_id, NULL, sysdate(), sysdate())");
  $stmt->bindValue(":user_id_id", $user_id_id, PDO::PARAM_INT);
  $stmt->bindValue("article_id", $article_id, PDO::PARAM_INT);
  $status = $stmt->execute();

  if ($status == false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
}
    $like_count = 0;
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE article_id = :article_id");
    $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $status = $stmt->execute();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $like_count += 1;
    }
    echo $like_count;

} else {
  // リクエストが無効な場合のエラーレスポンスを返す
  http_response_code(400);
  echo "無効なリクエストです";
}
?>