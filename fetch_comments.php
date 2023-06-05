<?php
session_start();
if (isset($_GET['article_id'])) {
    $articleId = $_GET['article_id'];
    $impression = $_GET['impression'] + 1;

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }
    $stm = $pdo->prepare("UPDATE articles SET impression = :impression WHERE id = :article_id");
    $stm->bindParam(':article_id', $articleId, PDO::PARAM_INT);
    $stm->bindParam(':impression', $impression, PDO::PARAM_INT);
    $statu = $stm->execute();

    if ($statu == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }

    $stmt = $pdo->prepare("SELECT * FROM comment WHERE article_id = :article_id");
    $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }

    $commentHtml = '';

    while ($resul = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $commentHtml .= "<div style='font-size:15px; display:flex; align-items:center;margin:0 1%;border-bottom:1px solid #79BD9A;'>";
        $commentHtml .= "<div style='width:25%;font-size:60%;margin-bottom:5px;'><img src='./img/" . $resul["prof_img_name"] . "' style='padding:5px;width:90px;height:90px;border-radius:50%; object-fit: cover;'><br>";
        $commentHtml .= $resul["name"] . "</div><div style='width:75%;display:flex;align-items:center;'>";
        $commentHtml .= "<div style='width:65%;padding:1%;'>".$resul["comment"] . "</div><br><div style='width:35%;padding:1%;font-size:80%;'>";
        if($_SESSION["user_id_id"]==$resul["user_id_id"]){
            $commentHtml .= "<button id='updat".$resul["id"]."'class='btn btn-outline-success' style='margin-bottom:10px;font-size:12px;margin-right:2.5px;width:45%;'>編集</button>";
            $commentHtml .= "<button id='delet".$resul["id"]."'class='btn btn-outline-success' style='margin-bottom:10px;font-size:12px;margin-left:2.5px;width:45%;'>削除</button>";
            }
        if(($resul["created_at"]!=$resul["updated_at"]) && ($resul["updated_at"]!= NULL)){
            $commentHtml  .= "Updated at<br>".$resul["updated_at"];
        }else{
            $commentHtml  .= $resul["created_at"];
        }
        $commentHtml .= "</div></div></div>";
        ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
         $(document).ready(function() {
                    $("#updat<?= $resul['id'] ?>").on('click', function() {
                        let comment = prompt("コメントを入力してください", "<?= $resul['comment'] ?>");
                        if (comment != null) {
                            $.ajax({
                                url: "edit_comment.php",
                                type: "POST",
                                data: {
                                    id: <?= $resul['id'] ?>,
                                    comment: comment
                                    // updated timeの追加
                                },
                                success: function(response) {
                                    // 更新成功時の処理
                                    alert("コメントが更新されました");
                                    location.reload(); // ページをリロードして更新を反映
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                }
                            });
                        }
                    });
                });

                $(document).ready(function() {
                    $('#delet<?= $resul['id'] ?>').click(function() {
                        // 確認ダイアログを表示
                        if (confirm('この投稿を削除しますか？')) {
                            // AJAXリクエストを送信して投稿を削除
                            $.ajax({
                                url: 'delete_comment.php',
                                type: 'POST',
                                data: { postId: <?= $resul['id']?> },
                                success: function(response) {
                                    // 成功時の処理
                                    location.reload(); // ページをリロードして更新を反映
                                },
                                error: function(xhr, status, error) {
                                    // エラー時の処理
                                    console.log(error);
                                }
                            });
                        }
                    });
                });
    </script>
    <?php
    }

    echo $commentHtml;
}
?>