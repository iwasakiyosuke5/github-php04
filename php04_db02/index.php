<?php
//0. SESSION開始！！
session_start();

include("funcs.php");

sschk();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>論文登録</title>
  <link rel="stylesheet" href="css/range.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/output.css">
  <style>div{padding: 10px;font-size:16px;}</style>
  <style>
        .spinner {
            display: none;
            border: 16px solid black;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            /* width: 120px;
            height: 120px; */
            /*下記はバージョン違い  */

            width: 6em;
            height: 6em;
            margin-top: -3.0em;
            margin-left: -3.0em;
            /* border-radius: 50%;
            border: 0.25em solid #ccc;
            border-top-color: #333; */
            animation: spin 500ms linear infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function showSpinner() {
            document.getElementById("spinner").style.display = "block";
        }
    </script>
</head>
<body id="main">

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="w-4/5 flex justify-between navbar-header">
        <div class="text-violet-700 text-2xl">論文共有アプリ</div>
        <div>ログイン中:[<?=$_SESSION["name"]?>さん]<a class="mr-4 navbar-brand border-b-2 border-gray-400" href="logout.php">ログアウト</a></div>
      </div>
      <div>
          <nav class="text-red-400 navbar navbar-default">論文登録</nav>
          <a class="navbar-brand bg-red-300 rounded px-1" href="select.php">データ一覧へ</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div id="spinner" class="spinner"></div>
<div>
  <div>
  <form method="post" action="insert.php" onsubmit="showSpinner()">
  <div class="jumbotron w-4/5 ml-2 bg-green-200 rounded">

   <fieldset>
    <div>
      <legend>気になった論文を登録/シェアしよう</legend>
      <div><label>Title：<input class="bg-slate-300 rounded pl-2" type="text" name="title" required></label></div>
      <div><label>Author：<input class="bg-slate-300 rounded pl-2" type="text" name="auther" required></label></div>
      <div><label>Jurnal：<input class="bg-slate-300 rounded pl-2" type="text" name="jurnal" required></label></div>
      <div><label>Publication Year：<input class="bg-slate-300 rounded pl-2" type="text" name="pYear" required></label></div>
      <div><label>DOI：<input class="bg-slate-300 rounded pl-2" type="text" name="doi" required></label></div>
      <div><label>Interest level：<select class="bg-slate-300 rounded pl-2" name="level" id="">
          <option value="★☆☆☆☆">★☆☆☆☆</option>
          <option value="★★☆☆☆">★★☆☆☆</option>
          <option value="★★★☆☆">★★★☆☆</option>
          <option value="★★★★☆">★★★★☆</option>
          <option value="★★★★★">★★★★★</option>
      </select></label></div>
      <div><label>Abstract on Abstract：<br><textArea class="bg-slate-300 rounded pl-2" name="abstract" rows="4" cols="40"></textArea></label>
      <input class="bg-red-300 rounded px-2" type="submit" value="送信"></div>
    </div>
  </fieldset>
  </div>
</form>

  </div>

</div>

<!-- Main[End] -->


</body>
</html>
