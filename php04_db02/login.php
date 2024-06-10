<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/output.css">
    <title>ログイン画面</title>
    <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
<header>
<div class="container-fluid">
  <div>
    <div class="text-violet-700 text-2xl">論文共有アプリ</div>
    <nav class="text-red-400 navbar navbar-default">LOGIN画面</nav>
  </div>
  
</div>
</header>
<!--  -->
<div class="jumbotron w-4/5 ml-2 bg-green-200 rounded">
ユーザー登録が済んでいない方のは<a href="user.php" class="text-red-500">こちらへ</a>
<form name="form1" action="logininsert.php" method="post">
ID:<input type="text" name="lid" class="bg-slate-300 rounded pl-2">
PW:<input type="password" name="lpw" class="bg-slate-300 rounded pl-2">
<input type="submit" value="ログイン" class="bg-red-300 rounded px-2">
</form>

</div>

</body>
</html>