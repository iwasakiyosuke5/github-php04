<?php

// 以下は検索が二つの時用
//エラー表示
ini_set("display_errors", 1);
session_start();

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

// 検索クエリの受け取り
// 値が設定されている場合はその値を、設定されていない場合は空の文字列''を$searchTitle/Autherに代入している。
$searchTitle = isset($_POST['search']) ? $_POST['search'] : '';
$searchAuther = isset($_POST['searchAuther']) ? $_POST['searchAuther'] : '';


// ２．データ登録SQL作成
// $sql = "SELECT * FROM gs_bm2_table";
$sql = "SELECT * FROM gs_bm2_table";
$wehreClauses = [];

if ($searchTitle !== '') {
  //  $sqlをSELECT * FROM gs_bm2_table WHERE title LIKE :search の形にするため
  $whereClauses[] = "(title LIKE :searchTitle OR abstract LIKE :searchTitle)";
}
if ($searchAuther !== '') {
  //  $sqlをSELECT * FROM gs_bm2_table WHERE title LIKE :search の形にするため
  $whereClauses[] = "auther LIKE :searchAuther";
}
if (!empty($whereClauses)) {
  $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$stmt = $pdo->prepare("$sql");

// 曖昧検索のプレースホルダーに値をバインド
if ($searchTitle !== '') {
  $stmt->bindValue(':searchTitle', '%' . $searchTitle . '%', PDO::PARAM_STR);
}
if ($searchAuther !== '') {
  $stmt->bindValue(':searchAuther', '%' . $searchAuther . '%', PDO::PARAM_STR);
}
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>興味ある論文一覧</title>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
        <nav class="text-red-400 navbar navbar-default">論文一覧</nav>
        <a class="navbar-brand bg-red-300 rounded px-1" href="index.php">データ登録へ</a>      </div>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div id="spinner" class="spinner"></div>
<div style="padding-left: 30px;">
<form id="searchForm" method="POST" action="select.php"  onsubmit="showSpinner()">
      <input class="bg-slate-300 rounded pl-2" type="text" name="search" placeholder="title/アブストを検索">
      <input class="bg-slate-300 rounded pl-2" type="text" name="searchAuther" placeholder="authorを検索">
      <input class="bg-red-300 rounded px-2" type="submit" value="検索">
      <button class="bg-red-100 rounded px-2" type="button" onclick="resetForm()">リセット</button>
</form>
</div>

<div>
    <div class="w-scleen bg-slate-100 rounded-lg container jumbotron">
    <?php if (count($values) > 0): ?>
  <form action="delete.php" method="post" onsubmit="showSpinner()">
          <table>
            <tr>
              <th><input type="checkbox" id="selectAll"><br></th>
              <th class="">Title</th>
              <th class="">Author</th>
              <th class="">Jurnal</th>
              <th class="">発行年</th>
              <th class="">気になる度</th>
              <th>直リンク</th>
              <th>Abstract</th>
              <th>登録日</th>
              <th>編集</th>
              <th>登録者</th>

            </tr>
            <?php $count = 0; foreach($values as $v){ $count++;?>
              <!-- 「$v){」を「$v):」 とした場合、-->
                <tr>
                <td style="border-bottom:1px solid #ccc;"><?php if($_SESSION['kanri_flg'] == 1 OR $_SESSION['name'] == $v["name"]):?><input type="checkbox" name="delete_ids[]" value="<?=$v["id"]?>"><?php endif;?></td>
                <td style="border-bottom:1px solid #ccc;"><?=h($v["title"]);?></td>
                <td style="border-bottom:1px solid #ccc; font-size: 14px"><?=h($v["auther"]);?></td>
                <td style="border-bottom:1px solid #ccc; font-size: 14px;"><?=h($v["jurnal"]);?></td>
                <td style="border-bottom:1px solid #ccc; font-size: 14px;"><?=h($v["pYear"]);?></td>
                <td style="border-bottom:1px solid #ccc; font-size: 14px;"><?=h($v["level"]);?></td>
                <td style="border-bottom:1px solid #ccc; font-size: 30px;"><a href="https://doi.org/<?=urlencode($v["doi"]);?>" target="_blank"><?="🔗";?></a></td>
                <td style="border-bottom:1px solid #ccc;"><?=h($v["abstract"]);?></td>
                <td style="border-bottom:1px solid #ccc;"><?=h($v["createdDate"]);?></td>
                <td style="border-bottom:1px solid #ccc;"><?php if($_SESSION['kanri_flg'] == 1 OR $_SESSION['name'] == $v["name"]):?><a href="edit.php?id=<?=$v["id"]?>">🔄</a><?php else :?>❌<?php endif;?></td>
                <td style="border-bottom:1px solid #ccc;"><?=h($v["name"]);?></td>
              </tr>

            <?php }?>
            <!-- 「}」を「endforeach;」 とする -->
          </table>
      <input class="bg-gray-900 text-white rounded px-2 mt-1" type="submit" value="check項目を削除"><br>
    </form>
  表示項目数：<?php echo "$count"; ?><br>
  <?php else: ?>
  検索結果が見つかりませんでした。
  <?php endif; ?>
  </div>
  <div class="mx-2 w-2/5"  style="padding-left: 30px; width: 400px; height: 400px;">
    <h3>気になる度割合</h3>
    <canvas id="mychart1"  style="width:100%; height: 100%;"></canvas>
  </div>


</div>


<!-- Main[End] -->


<script>

document.getElementById('selectAll').addEventListener('change', function(){
  
  let checkboxes = document.querySelectorAll('input[type="checkbox"][name="delete_ids[]"]');
  
  // 取得したすべてのチェックボックスの状態を全選択チェックボックスの状態と同じに設定
  for(let checkbox of checkboxes){
    checkbox.checked = this.checked;
  }
});


//JSON受け取り
const json = JSON.parse('<?=$json?>')
console.log(json);
// php側で受け取りたいとを厳選した際のやり方
// const jsonLevel = JSON.parse('$jsonLevel') $jsonを囲む必要あり
// console.log(jsonLevel);
const jsonLevel =json.map(item => {
  return {level: item.level};
});
console.log(jsonLevel);
console.log(jsonLevel.length);
//グラフ作成のためのカウントとり 
const levelCounts = {
  '★☆☆☆☆': 0,
  '★★☆☆☆': 0,
  '★★★☆☆': 0,
  '★★★★☆': 0,
  '★★★★★': 0
};
// jsonLevel配列から各評価の数をカウント
jsonLevel.forEach(item => {
  levelCounts[item.level]++;
});
// カウントした数をdata配列に追加
const data = Object.values(levelCounts);

console.log(levelCounts);
console.log(data);

const  ctx1 = document.getElementById("mychart1");
const myChart1 = new Chart(ctx1, {
  type: 'pie',
  data: {
    labels: [
    '★☆☆☆☆',
    '★★☆☆☆',
    '★★★☆☆',
    '★★★★☆',
    '★★★★★',
    ],
    datasets: [{
      label: '',
      data: data,
      backgroundColor: [
        'rgb(54, 162, 235)',
        'rgb(255, 99, 132)',
        'rgb(255, 99, 230)',
        'rgb(255, 150, 132)',
        'rgb(150, 230, 150)',
      ],
      // hoverBackgroundColor: '',
      hoverOffset: 5,
    }]
  },
  options: {
      plugins: {
          datalabels: {
              color: 'white',
              display: true,
              font: {
                  weight: 'bold'
              },
              formatter: (value, context) => {
                  return context.chart.data.labels[context.dataIndex] + '\n' + value;
              }
          }
      }
  },
  plugins: [ChartDataLabels]
});

// リセット機能
  function resetForm() {
  document.querySelector('#searchForm [name="search"]').value = '';
  document.querySelector('#searchForm [name="searchAuther"]').value = '';
  document.querySelector('#searchForm').submit();
}
</script>
</body>
</html>
