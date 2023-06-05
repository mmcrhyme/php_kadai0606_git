<?php
session_start();
if (isset($_POST['user_id_id'])) {
    $user_id_id = $_POST['user_id_id'];

    try {
        $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
    } catch (PDOException $e) {
        exit('DbConnectError:' . $e->getMessage());
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id_id");
    $stmt->bindParam(':user_id_id', $user_id_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        exit("ErrorQuery:" . $error[2]);
    }

    $prof = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<!-- 最初の設定は終わっています　必要な方は触ってください -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
  <link rel="stylesheet" href="reset.css">
  <link rel="stylesheet" href="style2.css">
  <!-- <link rel="stylesheet" href="main.js"> -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> -->
</head>

<body>

<div class="header" style="display:flex; align-items:center;">
    <div id="logo" style="width:40%;height:100%; display:flex; align-items:center;">
          <img style="width:12%;margin:5px;" class="logo_img" src="img/logo1.jpeg" alt="Flourimist">
          <div class="service_name" style="margin-left:10px;font-size:60px;font-family: 'Chalkduster',sans-serif;">Flourimist</div>
    </div>
    <div id="logout" style="width:60%;padding-left:52%;margin-top:0.5%;text-align:center;display:flex;flex-flow:column;">
        <a href="home.php">
        <div>
        <img style="width:35%;" class="logout" src="img/logout1.png" alt="Flourimist">
        </div>
        </a>
        <div>back</div>
    </div>
</div>

<div class="content">
<div class="page" id="user_page">
        <div id="user_prof" style="display:flex;justify-content:center;align-items:center;">
            <div id="user_prof_img" style="width:30%;margin:5%;align-items:center;">
                <img src="./img/<?=$prof["prof_img_name"]?>" alt="プロフィール画像" style="padding-top:5px;width:110px;height:110px;border-radius:50%; object-fit: cover;">
            </div>
            <div style='width:70%;margin:0% 0% 1% 3%;'>
            <div style="margin-left:1%;font-size:100%;"><?="ID: ".$prof["user_id"]."<br> Name: ".$prof["name"]?></div>
            <div id="post_count"></div>  
            <?php
                try {
                    $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root', '');
                } catch (PDOException $e) {
                    exit('DbConnectError:' . $e->getMessage());
                }

                $followButtonText = '';
                $stmt = $pdo->prepare("SELECT * FROM follows WHERE follower_id = :follower_id AND followee_id = :followee_id");
                $stmt->bindParam(':follower_id', $_SESSION['user_id_id'], PDO::PARAM_INT);
                $stmt->bindParam(':followee_id', $user_id_id, PDO::PARAM_INT);
                $status = $stmt->execute();
                $followData = $stmt->fetch();
                
                if ($followData) {
                    // フォローしている場合はアンフォローボタンを表示
                    $followButtonText = 'フォロー中'; ?>
                    <script>
                    </script>
                <?php
                } else {
                    // フォローしていない場合はフォローボタンを表示
                    $followButtonText = 'フォローする';?>
                    <script>
                    </script>
                <?php    
                }
            ?>
            <button id = "follow" class="btn btn-outline-success" style="width:70%;margin-top:10px;border-radius:10px;font-size:80%;" data-text-default="フォローする" data-text-clicked="フォロー中"><?=$followButtonText?></button>
            </div>
            </div>
        <div id="bio" style='margin:0% auto 10%;width: 80%;height: auto;border: 2px solid #79BD9A;'>
            <div style='padding:3%'><?=$prof['bio']?></div>
        </div>
        </div>

        <script>
                $(document).ready(function() {
                    // ページ読み込み時にCookieから状態を取得し適用
                    var followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?> = getCookie('followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?>');
                    if (followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?> === 'follow') {
                        // 状態がfollowの場合の処理
                        $('#follow').addClass('active');
                    }

                $('#follow').on('click', function() {
                    // event.preventDefault();
                    // $(this).toggleClass('active');
            
                    if($(this).hasClass('active')){
                        $(this).removeClass('active');
                        followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?> = 'unfollow';
                        var text = $(this).data('text-default');
                        $.ajax({
                        url: 'delete_follow.php',
                        type: 'POST',
                        data: {
                        followerId: <?php echo $_SESSION['user_id_id']; ?>,
                        followeeId: <?php echo $user_id_id; ?>
                        },
                        success: function(data) {
                        // 成功時の処理
                        console.log('フォロー解除が成功しました');
                        },
                        error: function() {
                        // エラー時の処理
                        console.log('フォロー解除に失敗しました');
                        }
                        });
                        
                    } else {
                        $(this).addClass('active');
                        followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?> = 'follow';
                        var text = $(this).data('text-clicked');
                        // AJAXリクエストを使用してサーバーサイドのPHPファイルにデータを送信
                        $.ajax({
                        url: 'follow.php',
                        type: 'POST',
                        data: {
                        followerId: <?php echo $_SESSION['user_id_id']; ?>,
                        followeeId: <?php echo $user_id_id; ?>
                        },
                        success: function(data) {
                        // 成功時の処理
                        console.log('フォローが成功しました');
                        },
                        error: function() {
                        // エラー時の処理
                        console.log('フォローに失敗しました');
                        }
                        });
                    }
                    // Cookieに状態を保存
                    setCookie('followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?>', followStatus<?=$_SESSION['user_id_id']?>_<?=$user_id_id?>, 30);
                    $(this).html(text);
                    
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

        </script>

    <div class="page" id="timelin" style ="width:75%;border-left: 10px dotted #79BD9A;overflow: auto;">
        <?php
            try{
                $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root','');
            } catch(PDOException $e){
                exit('DbConnectError:'.$e->getMessage());
            }

            $stmt = $pdo->prepare("SELECT * FROM articles WHERE user_id_id = :user_id_id");
            $stmt->bindParam(':user_id_id', $user_id_id, PDO::PARAM_INT);
            $status = $stmt->execute();

            $vie = "";
            if($status == false){
                $error = $stmt->errorInfo();
                exit("ErrorQuery:".$error[2]);
            }else{
                    $post_count = 0;
                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $vie .= "<div style='font-size:20px; display:flex; justify-content:space-between; align-items: center;'>";
                    $vie .= "<div style='width:20%; margin-left:20px;font-size:80%;margin-bottom:5px;'><img src='./img/".$result["prof_img_name"]."' style='padding:5px;width:110px;height:110px;border-radius:50%; object-fit: cover;'><br>";
                    $vie .= $result["name"]."</div>";
                    $vie .= "<div style='width:56%; padding:20px;'><h5 style='font-weight:bold;'>タイトル：【";
                    $vie .= $result["title"]."】</h5>".$result["body"]."</div><br><br><div style='width:24%;margin-top:5px;'>";
                    $vie .= "<div id='post_time' style='padding:10px;font-size:14px;'>";
                    if(($result["created_at"]!=$result["updated_at"]) && ($result["updated_at"]!= NULL)){
                        $vie .= "Updated at<br>".$result["updated_at"];
                    }else{
                    $vie .= $result["created_at"];
                    }
                    $vie .= "</div></div></div>";?>
                    <div class="post">
                        <?=$vie?>
                    </div>
                    
              <?php 
                $post_count += 1;
                $vie = "";
               }
            }
?>
<script>
    $("#post_count").html("投稿数: <?=$post_count?>");
</script>

    </div>
</div>
</div>

<div class="footer">
        <p>copyrights 2023 まるしぃ Tokyo All RIghts Reserved.</p>
</div>

</body>

</html>