<?php
//エラー表示
ini_set("display_errors", 1);
session_start();

//1. POSTデータ取得
$title = $_POST["title"];
$auther = $_POST["auther"];
$jurnal = $_POST["jurnal"];
$pYear = $_POST["pYear"];
$doi = $_POST["doi"];
$level = $_POST["level"];
$abstract = $_POST["abstract"];
$name = $_SESSION["name"];

var_dump($_POST);

//2. DB接続します
include("funcs.php");
$pdo = db_conn();


//３．データ登録SQL作成
// 下記一文のbind変数（:XXXX）にはまだ入っていない。
$sql = "INSERT INTO gs_bm2_table(title,auther,jurnal,pYear,doi,level,abstract,createdDate,name)VALUES(:title,:auther,:jurnal,:pYear,:doi,:level,:abstract,sysdate(),:name)";
$stmt = $pdo->prepare($sql);
//       bindValue('bind変数', $変数, PDO::PARAM_XXX)
$stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':auther', $auther, PDO::PARAM_STR);  // String
$stmt->bindValue(':jurnal', $jurnal, PDO::PARAM_STR);  // String
$stmt->bindValue(':pYear', $pYear, PDO::PARAM_INT);  // Integer
$stmt->bindValue(':doi', $doi, PDO::PARAM_STR);  // String
$stmt->bindValue(':level', $level, PDO::PARAM_STR);  // Integer
$stmt->bindValue(':abstract', $abstract, PDO::PARAM_STR);  // String// executeで実行
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  // String// executeで実行
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
      sql_error($stmt);
}else{
  //５．index.phpへリダイレクト "Location: "のコロンの後ろは半スペ！
      redirect("index.php");
}
?>
