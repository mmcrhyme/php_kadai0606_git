<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <link rel="stylesheet" href="style.css">
    <script
  src="https://code.jquery.com/jquery-3.7.0.js"
  integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <title>Home</title>
</head>
<body>

<div id="container">
          <div class="logo"><img class="logo_img" src="img/logo1.jpeg" alt="Flourimist"></div>
          <div class="service_name">Flourimist</div>
    </div>
<div>
<h1 style="letter-spacing:1px;text-align:center;margin-top:1%;color:white" class="h1_log">Login</h1>
   <form action="login.php" method="post" style="text-align:center;" >
     <input name="lid" placeholder="user ID"><br>
     <input type="password" name="lpw" placeholder="password"><br>
     <button class="button" type="submit" style="margin-top:10px;">Login</button>
   </form>
<h1 style="letter-spacing:1px;text-align:center;margin-top:2.5%;color:white" class="h1_log">Signup</h1>
<form action="register.php" method="post" style="text-align:center;" enctype="multipart/form-data">
     <input name="user_id" placeholder="user ID"><br>
     <input name="user_name" placeholder="user name"><br>
     <input type="password" name="user_password" placeholder="password"><br>
     <div>
     <p style="color:white;margin-bottom:0;">Upload profile photo</p>
     <input id="imageInput" type="file" name="fname" accept="image/*" style="margin-left:80px;">
     <!-- <div id="previewContainer"></div>
     <button id="cropButton">トリミング</button> -->
     <!-- <p id="filename" style="color:white;">選択されていません</p> -->
     </div>
     <!-- <p style="color:white;">好きな動物を選択（プロフィール画像になります）</p> -->
     <!-- <select name="animal">
      <option value="buta">ブタ</option>
      <option value="kuma">クマ</option>
      <option value="inu">イヌ</option>
      <option value="neko">ネコ</option>
      <option value="zou">ゾウ</option>
      <option value="uma">ウマ</option>
      <option value="lion">ライオン</option>
      <option value="sai">サイ</option>
      <option value="tora">トラ</option>
      <option value="usagi">ウサギ</option>
      <option value="panda">パンダ</option>
      <option value="saru">サル</option>
      <option value="pengin">ペンギン</option>
      <option value="hitsuji">ヒツジ</option>
      <option value="koara">コアラ</option>
      <option value="risu">リス</option>
     </select> -->
     <button class="button" id="register" type="submit" style="margin-top:10px;">Signup</button>
</form>
</div>

<script>
  $('#register').on('change', function () {
    var file = $(this).prop('files')[0];
    $('#filename').text(file.name);
});

// $(document).ready(function() {
//   let cropper;

//   $('#imageInput').on('change', function(event) {
//     const file = event.target.files[0];

//     if (file) {
//       const reader = new FileReader();

//       reader.onload = function(e) {
//         const image = new Image();
//         image.src = e.target.result;

//         $(image).on('load', function() {
//           // 画像を表示
//           $('#previewContainer').html(image);

//           // Cropper.jsのインスタンスを作成
//           cropper = new Cropper(image, {
//             aspectRatio: 1, // トリミングの縦横比
//             viewMode: 2, // 表示モード
//             movable: false, // 移動可否
//             zoomable: true, // ズーム可否
//             rotatable: false, // 回転可否
//             scalable: false, // 変形可否
//             dragMode: 'move', // ドラッグによる移動を有効化
//             autoCropArea: 0.5, // 初期トリミング範囲の比率（50%）
//             cropBoxResizable: true, // トリミングボックスのリサイズ可否
//           });
//         });

//         $(image).on('error', function() {
//           console.error('Failed to load the image.');
//         });
//       };

//       reader.readAsDataURL(file);
//     }
//   });

//   $('#cropButton').on('click', function() {
//     // トリミング結果を取得
//     const croppedCanvas = cropper.getCroppedCanvas();

//     // トリミング結果を表示
//     $('#previewContainer').html(croppedCanvas);
//   });
// });
</script>

</body>
</html>