<?php
session_start();

// ファイルの読み込み
require_once '../../app/QuestionLogic.php';
require_once '../../app/CategoryLogic.php';
require_once '../../app/UserLogic.php';

// エラーメッセージ
$err = [];

// ログインチェック処理
$result = UserLogic::checkLogin();
if(!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userLogin/home.php');
    return;
}

// カテゴリ取得処理
$categories = CategoryLogic::getCategory();

// バリデーション
$question_id = filter_input(INPUT_POST, 'question_id');
    if(empty($question_id)) {
        $err[] = '質問を選択し直してください';
    }
$answer_id = filter_input(INPUT_POST, 'answer_id');
    if(empty($answer_id)) {
        $err[] = '返答を選択し直してください';
    }
if(count($err) === 0) {
    //質問を引っ張る処理
    $answer = QuestionLogic::displayOneAnswer($answer_id);
    if(empty($answer)){
        $err[] = '返答の読み込みに失敗しました';
    }
}

// ボタン押下時の処理（成功でページ移動）
if(isset($_POST['a_dlt_conf'])) {
    if(!$_POST['answer_id']) {
        $err['a_id'] = '返答が選択されていません';
    } else {
        $_SESSION['a_data']['answer_id'] = filter_input(INPUT_POST, 'answer_id', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['a_data']['question_id'] = filter_input(INPUT_POST, 'question_id', FILTER_SANITIZE_NUMBER_INT);
    }
    if(count($err) === 0) {
        header('Location: aDeleteComp.php');
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/mypage.css">
    <link rel="stylesheet" type="text/css" href="../css/top.css">
    <title>質問回答 削除</title>
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
                <p class="h4">返答内容</p>
                <form method="POST" action="">
                    <!-- エラー表示 -->
                    <div>
                        <?php if(isset($err['a_id'])): ?>
                        <?php echo $err['a_id']; ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if(isset($err['message'])): ?>
                        <?php echo $err['message']; ?>
                        <?php endif; ?>
                    </div>
                    <!-- 質問内容表示 -->
                    <div>本文：<?php echo htmlspecialchars($answer['message'], \ENT_QUOTES, 'UTF-8'); ?></div>
                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                    <input type="hidden" name="answer_id" value="<?php echo $answer_id; ?>">
                    <input type="submit" name="a_dlt_conf" value="削除">
                </form>
                <button type="button" class="btn btn-outline-dark fw-bold mb-5" onclick="location.href='../userLogin/home.php'">TOP</button>
                <button type="button" class="btn btn-outline-dark fw-bold mb-5" onclick="history.back()">戻る</button>
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
                            <a class="nav-link small" href="index.php">質問</a>
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