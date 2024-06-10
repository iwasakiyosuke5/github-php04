<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/output.css">
    <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
    
<!-- Head[Start] -->
<header>
<nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <div class="text-violet-700 text-2xl">論文共有アプリ</div>
      <nav class="text-red-400 navbar navbar-default">ユーザー登録</nav>
    
      <a class="navbar-brand bg-red-300 rounded px-1" href="login.php">ログイン画面へ戻る</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="userInsert.php">
  <div class="jumbotron w-4/5 ml-2 bg-green-200 rounded">
   <fieldset>
    <div><legend>ユーザー登録</legend></div>
     <div class=""><label>名前：<input class="bg-slate-300 rounded pl-2" type="text" name="name" required></label></div>
     <div class=""><label>Login ID：<input class="bg-slate-300 rounded pl-2" type="text" name="lid" required></label></div>
     <div><label>Login PW：<input class="bg-slate-300 rounded pl-2" type="text" name="lpw" required></label>
     <input class="bg-red-300 rounded px-2 cursor-pointer" type="submit" value="登録"></div>
     <!-- <label>管理FLG：
      一般<input type="radio" name="kanri_flg" value="0">
      管理者<input type="radio" name="kanri_flg" value="1"> -->
    </label>
     <!-- <label>退会FLG：<input type="text" name="life_flg"></label><br> -->
    </fieldset>
  </div>
</form>
<!-- Main[End] -->



</body>
</html>