<?php
session_start();
if (isset($_GET['user_id_id'])) {
    $follower_id = $_GET['user_id_id'];
    //フォローしてる人だけの投稿を表示、コメントも。。。？

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }
    $stmt = $pdo->prepare("SELECT * FROM follows WHERE follower_id = :follower_id");
    $stmt->bindParam(':follower_id', $follower_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }
    $view = "";
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $stm = $pdo->prepare("SELECT * FROM articles WHERE user_id_id = :user_id_id");
        $stm->bindParam(':user_id_id', $result['followee_id'], PDO::PARAM_INT);
        $statu = $stm->execute();

        while($resul = $stm->fetch(PDO::FETCH_ASSOC)){
            $view .= "<div style='font-size:20px; display:flex; justify-content:space-between; align-items: center;'>";
            $view .= "<div style='width:20%; margin-left:20px;font-size:80%;margin-bottom:5px;'><img src='./img/".$resul["prof_img_name"]."' style='padding:5px;width:110px;height:110px;border-radius:50%; object-fit: cover;'><br>";
        if($_SESSION["user_id_id"]!=$resul["user_id_id"]){
            $view .= "<form id='for' action='user_profile.php' method='post'>";
            $view .= "<input id='ui' type='text' name='user_id_id' style='display: none;' value='".$resul['user_id_id']."'>";
            $view .= "<button id='user_profile' style='border:none;outline: none;background: transparent;'>".$resul["name"]."</button></form></div>";
        }else{
            $view .= $resul["name"]."</div>";
        }
            $view .= "<div style='width:56%; padding:20px;'><h5 style='font-weight:bold;'>タイトル：【";
            $view .= $resul["title"]."】</h5>".$resul["body"]."</div><br><br><div style='width:24%;margin-top:5px;'>";
            $view .= "<div id='post_time' style='padding:10px;font-size:14px;'>";
        if(($resul["created_at"]!=$resul["updated_at"]) && ($resul["updated_at"]!= NULL)){
            $view .= "Updated at<br>".$resul["updated_at"];
        }else{
            $view .= $resul["created_at"];
        }

        $view .= "</div><div style='display:flex;justify-content:center;align-items:center;'><button id = 'like".$resul["id"]."' style='width:12%;margin-bottom:5px;border:none;outline: none;background: transparent;'><img id='like_img".$resul["id"]."' style='width:200%;' src='img/like1.png' alt='like'></button>";
                    
        $like_count = 0;
        $st = $pdo->prepare("SELECT * FROM likes WHERE article_id = :article_id");
        $st->bindParam(':article_id', $resul['id'], PDO::PARAM_INT);
        $stat = $st->execute();
        while($resu = $st->fetch(PDO::FETCH_ASSOC)){
            $like_count += 1;
        }

        $view .= "<div id='like_count".$resul["id"]."' style='width:20%;margin:0 8px;'>".$like_count."</div>";

        $view .= "</div><button id='article".$resul["id"]."'class='btn btn-outline-success' style='width:82%;font-size:15px;margin-bottom:5px;'>コメント</button>";
        $view .= "</div></div>";?>
        <div class="post">
            <?=$view?>
        </div>
        
<script>
    $(document).ready(function() {
                    // ページ読み込み時にCookieから状態を取得し適用
                    var likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?> = getCookie('likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?>');
                    if (likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?> === 'like') {
                        // 状態がfollowの場合の処理
                        $('#like<?=$resul['id']?>').addClass('active');
                        var currentImage = $('#like_img<?=$resul["id"]?>').attr('src');
                        $('#like_img<?=$resul["id"]?>').attr('src', 'img/like2.png');
                    }

                $('#like<?=$resul['id']?>').on('click', function() {
                    // event.preventDefault();
                    // $(this).toggleClass('active');
                    var currentImage = $('#like_img<?=$resul["id"]?>').attr('src');
            
                    if($(this).hasClass('active')){
                        $(this).removeClass('active');
                        $('#like_img<?=$resul["id"]?>').attr('src', 'img/like1.png');
                        likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?> = 'unlike';
                        $.ajax({
                        url: 'delete_like.php',
                        type: 'POST',
                        data: {
                            article_id: <?=$resul['id']?>,
                            user_id_id: <?=$_SESSION["user_id_id"]?> 
                        },
                        success: function(response) {
                        // 成功時の処理
                        $("#like_count<?=$resul['id']?>").html(response);
                        },
                        error: function() {
                        // エラー時の処理
                        console.log('いいね解除に失敗しました');
                        }
                        });
                        
                    } else {
                        $(this).addClass('active');
                        $('#like_img<?=$resul["id"]?>').attr('src', 'img/like2.png');
                        likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?> = 'like';
                        // AJAXリクエストを使用してサーバーサイドのPHPファイルにデータを送信
                        $.ajax({
                                url: "like.php",
                                type: "POST",
                                data: {
                                    article_id: <?=$resul['id']?>,
                                    user_id_id: <?=$_SESSION["user_id_id"]?> 
                                },
                                success: function(response) {
                                    // 更新成功時の処理
                                    $("#like_count<?=$resul['id']?>").html(response);
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);
                                }
                        });
                    }

                    // Cookieに状態を保存
                    setCookie('likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?>', likeStatus<?=$_SESSION['user_id_id']?>_<?=$resul['id']?>, 30);
                    
                });

                    // Cookieの取得
                    function getCookie(name) {
                    var value = "; " + document.cookie;
                    var parts = value.split("; " + name + "=");
                    if (parts.length === 2) {
                        return parts.pop().split(";").shift();
                    }
                    }

                    // Cookieの設定
                    function setCookie(name, value, days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + date.toUTCString();
                    document.cookie = name + "=" + value + "; " + expires + "; path=/";
                    }
                });
    

    $(document).ready(function() {
        $("#article<?= $resul['id'] ?>").on('click', function() {
            $("#res").html("<?php
                $com = "";
                $com .= "<div style='font-size:15px; display:flex; align-items:center;margin:0 2%;border-bottom:1px solid #79BD9A;'>";
                $com .= "<div style='width:38%; margin-left:5px;font-size:80%;margin-bottom:5px;'><img src='./img/".$resul["prof_img_name"]."' style='padding:5px;width:90px;height:90px;border-radius:50%; object-fit: cover;'><br>";
                $com .= $resul["name"]."</div><div style='width:62%;padding-right:2%;'><p style='font-weight:bold;'>タイトル：【";
                $com .= $resul["title"]."】</p>".$resul["body"]."</div><br><br></div>";
                echo $com;
            ?>");
            $("#form").css('visibility', 'visible');
            $("#ai").val("<?= $resul['id'] ?>");
            $("#commenthtml").css('visibility', 'visible');
            $.ajax({
                url: "fetch_comments.php", // コメントデータを取得するPHPファイルのパス
                type: "GET",
                data: {
                    article_id: <?= $resul['id'] ?>, // 記事のIDをパラメータとして渡す
                    impression: <?= $resul['impression'] ?>
                },
                success: function(response) {
                    $("#commentpage").html(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<?php 
$view = "";
}} ?>
    </script>
    <?php
}
?>