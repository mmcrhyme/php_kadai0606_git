<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $comment = $_POST["comment"];

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }

    $stmt = $pdo->prepare("UPDATE comment SET comment = :comment, updated_at = sysdate() WHERE id = :id");
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }
}
?>