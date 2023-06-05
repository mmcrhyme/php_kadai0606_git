<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 投稿IDを取得
    $postId = $_POST["postId"];

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }

    // データベースから投稿を削除
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :postId");
    $stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
    $stmt->execute();

    // 成功レスポンスを返す
    http_response_code(200);
    echo "投稿が削除されました";
} else {
    // エラーレスポンスを返す
    http_response_code(400);
    echo "リクエストが無効です";
}
?>