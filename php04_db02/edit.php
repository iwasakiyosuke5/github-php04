<?php
ini_set("display_errors", 1);
session_start();
// select.phpの編集ボタンからの受け取り
$id = $_GET["id"];

// db接続
include("funcs.php");
$pdo = db_conn();

//データ登録SQL作成
$sql = "SELECT * FROM gs_bm2_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
    sql_error($stmt);
}

// 
$row =  $stmt->fetch(); //1行のみ
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ編集</title>
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
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="w-4/5 flex justify-between navbar-header">
        <div class="text-violet-700 text-2xl">論文共有アプリ</div>
        <div>ログイン中:[<?=$_SESSION["name"]?>さん]<a class="mr-4 navbar-brand border-b-2 border-gray-400" href="logout.php">ログアウト</a></div>
      </div>
      <div>
        <nav class="text-red-400 navbar navbar-default">論文一覧</nav>
        <a class="navbar-brand bg-red-300 rounded px-1" href="select.php">データ一覧へ</a></div>
      </div>
    </div>
  </nav>
</header>

<!-- Head[End] -->

<!-- Main[Start] -->
<div id="spinner" class="spinner"></div>
<form method="POST" action="update.php" onsubmit="showSpinner()">
  <div class="jumbotron w-4/5 ml-2 bg-green-200 rounded">
  <fieldset>
    <div>
    <legend>編集ページ</legend>
     <div>Title：<input class="bg-slate-300 rounded w-4/5" type="text" name="title" value="<?=$row["title"]?>" required></div>
     <div>Author：<input class="bg-slate-300 rounded w-4/5" type="text" name="auther" value="<?=$row["auther"]?>" required></div>
     <div>Jurnal：<input class="bg-slate-300 rounded w-4/5" type="text" name="jurnal" value="<?=$row["jurnal"]?>" required></div>
     <div>Publication Year：<input class="bg-slate-300 rounded" type="text" name="pYear" value="<?=$row["pYear"]?>" required></div>
     <div>DOI：<input class="bg-slate-300 rounded w-2/5" type="text" name="doi" required value="<?=$row["doi"]?>"></div>
     <div>Interest level：<select class="bg-slate-300 rounded w-1/5" name="level" id="">
        <option value="<?=$row["level"]?>"><?=$row["level"]?></option>
        <option value="★☆☆☆☆">★☆☆☆☆</option>
        <option value="★★☆☆☆">★★☆☆☆</option>
        <option value="★★★☆☆">★★★☆☆</option>
        <option value="★★★★☆">★★★★☆</option>
        <option value="★★★★★">★★★★★</option>
     </select></div>
     <label>Abstract on Abstract：<br><textArea class="bg-slate-300 rounded w-full" name="abstract" rows="4" cols="40"><?=$row["abstract"]?></textArea></label><br>
     <input type="hidden" name="id" value="<?=$row["id"]?>">
     <div class="flex justify-end"><input class="px-2 bg-red-300 rounded"  type="submit" value="送信"></div>
    </div>
  </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>

