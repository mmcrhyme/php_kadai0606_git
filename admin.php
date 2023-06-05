<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title>Document</title>
</head>
<body>

    <div style="display:flex;justify-content:center;">
        <div style="position:relative;width:50%;height:70%;">
            <canvas id="barChart"></canvas>
        </div>
        <div style="position:relative;width:50%;height:70%;overflow:auto;">
        <div style='font-size:30px;text-align:center;'>インプレッション数ランキング</div>
            <?php 
                 try{
                    $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root','');
                } catch(PDOException $e){
                    exit('DbConnectError:'.$e->getMessage());
                }
                
                 $stm = $pdo->prepare("SELECT * FROM articles ORDER BY impression DESC LIMIT 5");
                 $statu = $stm->execute();
                 if($statu == false){
                     $error = $stm->errorInfo();
                     exit("ErrorQuery:".$error[2]);
                 }else{
                     while($v = $stm->fetch(PDO::FETCH_ASSOC)){
                        $vie = '';
                        $vie .= "<div style='font-size:20px; display:flex; justify-content:space-between; align-items: center;'>";
                        $vie .= "<div style='width:20%; margin-left:20px;font-size:80%;margin-bottom:5px;text-align:center;'><img src='./img/".$v["prof_img_name"]."' style='padding:5px;width:110px;height:110px;border-radius:50%; object-fit: cover;'><br>";
                        $vie .= $v["name"]."</div>";
                        $vie .= "<div style='width:50%; padding:20px;text-align:center;'><h5 style='font-weight:bold;'>タイトル：【";
                        $vie .= $v["title"]."】</h5>".$v["body"]."</div><br><br><div style='width:30%;margin-top:5px;'>";
                        $vie .= "インプレッション数：".$v['impression']."</div></div>";?>
                        <div class="post">
                            <?=$vie?>
                        </div>
                    <?php }
                 }?>
        </div>
    </div>
    <a href="home.php">戻る</a>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <?php
            try{
                $pdo = new PDO('mysql:dbname=gs_db_525; charset=utf8;host=localhost', 'root','');
            } catch(PDOException $e){
                exit('DbConnectError:'.$e->getMessage());
            }

            $stmt = $pdo->prepare("SELECT * FROM articles");
            $status = $stmt->execute();

            $pertime_data = [];
            if($status == false){
                $error = $stmt->errorInfo();
                exit("ErrorQuery:".$error[2]);
            }else{
                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $d = '';
                    $d = $result['created_at'];
                    $hour = date('H', strtotime($d));
                    array_push($pertime_data,$hour);
                }
            }
// whileで行末までループ処理
?><script>
    let json_data = [];
    let data1 = "";
</script><?php
  $json=json_encode($pertime_data);
  ?>
  <script>
    data1 = JSON.parse('<?=$json?>'); //JSON文字列→配列に変換
    // json_data.push(data1);
    // data1 = "";
    console.log(data1);
  </script>
<?php
?>
<script>
    // let ob = Object.keys(json_data);
    // console.log(ob);
//     // ob.forEach((key) => console.log(json_data[key].age))
//     ob.forEach((key) => console.log(json_data[key].created_at))
    let data = new Array(data1.length);
    let count0=0; let count1=0;
    let count2=0; let count3=0;
    let count4=0; let count5=0;
    let count6=0; let count7=0;
    let count8=0; let count9=0;
    let count10=0; let count11=0;
    let count12=0; let count13=0;
    let count14=0; let count15=0;
    let count16=0; let count17=0;
    let count18=0; let count19=0;
    let count20=0; let count21=0;
    let count22=0; let count23=0;
    for(let i=0; i<data1.length; i++){
        data[i] = data1[i];
        if(data[i]==0){
            count0 += 1;
        }else if(data[i]==1){
            count1 += 1;
        }else if(data[i]==2){
            count2 += 1;
        }else if(data[i]==3){
            count3 += 1;
        }else if(data[i]==4){
            count4 += 1;
        }else if(data[i]==5){
            count5 += 1;
        }else if(data[i]==6){
            count6 += 1;
        }else if(data[i]==7){
            count7 += 1;
        }else if(data[i]==8){
            count8 += 1;
        }else if(data[i]==9){
            count9 += 1;
        }else if(data[i]==10){
            count10 += 1;
        }else if(data[i]==11){
            count11 += 1;
        }else if(data[i]==12){
            count12 += 1;
        }else if(data[i]==13){
            count13 += 1;
        }else if(data[i]==14){
            count14 += 1;
        }else if(data[i]==15){
            count15 += 1;
        }else if(data[i]==16){
            count16 += 1;
        }else if(data[i]==17){
            count17 += 1;
        }else if(data[i]==18){
            count18 += 1;
        }else if(data[i]==19){
            count19 += 1;
        }else if(data[i]==20){
            count20 += 1;
        }else if(data[i]==21){
            count21 += 1;
        }else if(data[i]==22){
            count22 += 1;
        }else if(data[i]==23){
            count23 += 1;
        }
    }
    let barCtx = document.getElementById("barChart");
    let barConfig = {
    type: 'bar',
    data: {
        labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
        datasets: [{
            data: [count0,count1,count2,count3,count4,count5,count6,count7,count8,count9,count10,count11,count12,count13,count14,count15,count16,count17,count18,count19,count20,count21,count22,count23],
            label:"全ユーザー時間帯別投稿数",
            backgroundColor: ['#008000'],
            borderWidth: 1,
        },
        ]
    },
    options: {
        scales: {
            x: {  // x軸設定
                barPercentage: 0.6,  // バーの幅を調整
                categoryPercentage: 0.8,  // バーの幅を調整
            },
            y: {  // y軸設定
                min: 0,
                max: 15,
            }
        }
    }
};
        let barChart = new Chart(barCtx, barConfig);


</script>
</table>
</body>
</html>
