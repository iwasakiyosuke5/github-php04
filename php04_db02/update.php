<?php
ini_set("display_errors", 1);
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得

$title = $_POST["title"];
$auther = $_POST["auther"];
$jurnal = $_POST["jurnal"];
$pYear = $_POST["pYear"];
$doi = $_POST["doi"];
$level = $_POST["level"];
$abstract = $_POST["abstract"];
$id = $_POST["id"];


//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "UPDATE gs_bm2_table SET title=:title,auther=:auther,jurnal=:jurnal,pYear=:pYear,doi=:doi,level=:level,abstract=:abstract WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':auther', $auther, PDO::PARAM_STR);  // String
$stmt->bindValue(':jurnal', $jurnal, PDO::PARAM_STR);  // String
$stmt->bindValue(':pYear', $pYear, PDO::PARAM_INT);  // Integer
$stmt->bindValue(':doi', $doi, PDO::PARAM_STR);  // String
$stmt->bindValue(':level', $level, PDO::PARAM_STR);  // Integer
$stmt->bindValue(':abstract', $abstract, PDO::PARAM_STR);  // String// executeで実行
$stmt->bindValue(':id',$id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

if (!$status) {
    $errorInfo = $stmt->errorInfo();
    echo "SQLSTATE error code: " . $errorInfo[0] . "\n";
    echo "Driver-specific error code: " . $errorInfo[1] . "\n";
    echo "Driver-specific error message: " . $errorInfo[2] . "\n";
}

//４．データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
        sql_error($stmt);
}else{
    //５．index.phpへリダイレクト "Location: "のコロンの後ろは半スペ！
        redirect("select.php");
}
?>