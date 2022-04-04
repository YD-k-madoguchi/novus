<?php
session_start();

// ファイルの読み込み
require_once '../../app/QuestionLogic.php';

// エラーメッセージ
$err = [];

// データの受け渡しチェック
if (isset($_SESSION['a_data']['answer_id']) &&
    isset($_SESSION['a_data']['message'])
    ) {        
    // 返答を編集する処理
    $hasEditted = QuestionLogic::editAnswer();
    if(!$hasEditted) {
        $err[] = '更新に失敗しました';
    }      
    // 返答を取得する処理
    $hasTaken = QuestionLogic::displayOneAnswer($_SESSION['a_data']['answer_id']);
    if(!$hasTaken) {
        $err[] = '返答の取り込みに失敗しました';
    }
}
var_dump($err);
var_dump($hasTaken);
var_dump($_SESSION['a_data']['answer_id']);
var_dump($_SESSION['a_data']['message']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../../css/top.css">
    <title>質問回答 編集</title>
</head>

<body>
    <!--メニュー-->
    <header>
        <div class="navtext-container">
            <div class="navtext">novus</div>
        </div>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="top"><a href="../userLogin/home.php">TOPページ</a></li>
            <li><a href="../myPage/index.php">マイページ</a></li>
            <li><a href="../todo/index.php">TO DO LIST</a></li>
            <li>
                <form type="hidden" action="../userLogin/logout.php" method="POST">
                    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <p class="h4">編集完了</p>
                <p>以下の内容で編集が完了しました</p>
                <div>本文：<?php echo $hasTaken['message']; ?></div>
                <form method="GET" name="form1" action="../question/qDisp.php">
                    <input type="hidden" name="question_id" value="<?php echo $hasTaken['question_id']; ?>">
                    <a href="javascript:form1.submit()">詳細画面へ</a>
                </form>
                <button type="button" class="btn btn-outline-dark fw-bold mb-5" onclick="location.href='../userLogin/home.php'">TOPへ戻る</button></body>
            </div>
        </div>
    </div>

    <!-- フッタ -->
    <footer class="h-10"><hr>
        <div class="footer-item text-center">
                <h4>novus</h4>
                <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                        <a class="nav-link small" href="../article/index.php">記事</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link small" href="../question/index.php">質問</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link small" href="../bookApi/index.php">本検索</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link small" href="../contact/index.php">お問い合わせ</a>
                    </li>
                </ul>
        </div>
        <p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>
    </footer>
</body>
</html>
