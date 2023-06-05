<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $edit_user_id = $_POST["edit_user_id"];
    $edit_user_name = $_POST["edit_user_name"];
    $bio = $_POST["bio"];

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }

    $stmt = $pdo->prepare("UPDATE users SET user_id = :user_id, name = :name, bio = :bio WHERE id = :id");
    $stmt->bindValue(':user_id', $edit_user_id, PDO::PARAM_STR);
    $stmt->bindValue(':name', $edit_user_name, PDO::PARAM_STR);
    $stmt->bindValue(':bio', $bio, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }
}
?>