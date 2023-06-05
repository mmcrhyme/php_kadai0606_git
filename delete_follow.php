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

  // フォローデータを削除
  $stmt = $pdo->prepare("DELETE FROM follows WHERE follower_id = :followerId AND followee_id = :followeeId");
  $stmt->bindValue(":followerId", $followerId, PDO::PARAM_INT);
  $stmt->bindValue(":followeeId", $followeeId, PDO::PARAM_INT);
  $status = $stmt->execute();

  if ($status) {
    // 成功レスポンスを返す
    http_response_code(200);
    echo "フォロー解除が成功しました";
  } else {
    // エラーレスポンスを返す
    http_response_code(500);
    echo "フォロー解除に失敗しました";
  }
} else {
  // リクエストが無効な場合のエラーレスポンスを返す
  http_response_code(400);
  echo "無効なリクエストです";
}
?>