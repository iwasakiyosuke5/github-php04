<?php

// idとpwを受け取る
$lid = $_POST["lid"]; //lid
$lpw = $_POST["lpw"]; //lpw

if(empty($lid)){
  echo "入力に不備があります。";
  echo "<br>";
  echo "<span id='countdown'>3</span>秒後に自動的に戻ります。";
  echo '<script>';
  echo "let countdown = 3;
          let countdownElement = document.getElementById('countdown');
          setInterval(function(){
              if (countdown >0){
                  countdown--;
                  countdownElement.textContent = countdown;
              }
          },1000);";
  echo 'setTimeout(function() {window.location.href = "login.php";}, 2900);'; // 2秒後にリダイレクト
  echo '</script>';
  exit();
}

//ログインできてからSESSION開始！！
session_start();

include("funcs.php");
$pdo = db_conn1();



//2. データ登録SQL作成
//* PasswordがHash化→条件はlidのみ！！
$stmt = $pdo->prepare("SELECT * FROM userTable WHERE lid=:lid"); 
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得(複数の時は$stmt->fetchColumn();)
$val = $stmt->fetch();         //1レコードだけ取得する方法

//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($lpw, $val["lpw"]); //$lpw = password_hash($lpw, PASSWORD_DEFAULT);   //パスワードハッシュ化
if($pw){ 
  //Login成功時
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["name"]      = $val['name'];
  //Login成功時
  if($val['kanri_flg'] == 1){
    //管理用HPへ
    redirect("allUser.php");
  }else{ 
    //一般用HPへ 
    redirect("index.php");

  }
  
}else{

  setcookie("PHPSESSID", "", time() - 3600, "/");
  session_destroy();

  //Login失敗時(login.phpへ)
  echo "ログインに失敗しました。";
  echo "<br>";
  echo "IDとPWを確認してください。";
  echo "<br>";
  echo "<span id='countdown'>3</span>秒後に自動的に戻ります。";
  echo '<script>';
  echo "let countdown = 3;
          let countdownElement = document.getElementById('countdown');
          setInterval(function(){
              if (countdown >0){
                  countdown--;
                  countdownElement.textContent = countdown;
              }
          },1000);";
  echo 'setTimeout(function() {window.location.href = "login.php";}, 2900);'; // 2秒後にリダイレクト
  echo '</script>';
  exit();

  // redirect("login.php");

}

exit();


?>

