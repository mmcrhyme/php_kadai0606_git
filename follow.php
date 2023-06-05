<?php
try {
  // データベースに接続
  $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
  exit('DbConnectError:' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // POSTデータを取得
  $followerId = $_POST["followerId"];
  $followeeId = $_POST["followeeId"];

  // フォローデータをデータベースに挿入
  $stmt = $pdo->prepare("INSERT INTO follows (follower_id, followee_id, created_at, updated_at)
                        VALUES (:followerId, :followeeId, sysdate(), sysdate())");
  $stmt->bindValue(":followerId", $followerId, PDO::PARAM_INT);
  $stmt->bindValue(":followeeId", $followeeId, PDO::PARAM_INT);
  $status = $stmt->execute();

  if ($status) {
    // 成功レスポンスを返す
    http_response_code(200);
    echo "フォローが成功しました";
  } else {
    // エラーレスポンスを返す
    http_response_code(500);
    echo "フォローに失敗しました";
  }
} else {
  // リクエストが無効な場合のエラーレスポンスを返す
  http_response_code(400);
  echo "無効なリクエストです";
}
?>