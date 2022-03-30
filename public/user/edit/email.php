<?php

session_start();

//ファイル読み込み
require_once '../../../app/UserLogic.php';
require_once '../../../functions.php';

//ログインしているか判定して、していなかったらログインへ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../register/form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//セッションに保存データがあるかを確認
if (isset($_SESSION['emailEdit'])) {
    //セッションから情報を取得
    $email = $_SESSION['emailEdit'];
} else {
    //セッションがなかった場合
    $email = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../CSS/mypage.css" />
    <link rel="stylesheet" type="text/css" href="../../CSS/top.css" />
    <title>会員情報変更[email]</title>
</head>

<body>
    <!--メニュー-->
    <header>
        <div class="navtext-container">
            <div class="navtext">Q&A SITE</div>
        </div>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>
        <ul class="menu">
            <li class="top"><a href="../login/home.php">TOPページ</a></li>
            <li><a href="../login/mypage.php">MyPageに戻る</a></li>
            <li><a href="#projects">質問 履歴</a></li>
            <li><a href="#contact">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form action="../login/logout.php" method="POST">
                    <input type="submit" name="logout" value="ログアウト">
                </form>
            </li>
        </ul>
    </header>

    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">アカウント編集画面</h2>
                <form action="../edit/emailC.php" method="POST">
                    <input type="hidden" name="formcheck" value="checked">
                    <div class="list">
                        <!--ユーザーが登録した名前を表示-->
                        <div class="text">
                            <label for="email" style="text-align:center">[Email]</label>
                            <p><input id="editdetail" type="text" name="email" value="<?php echo htmlspecialchars($login_user['email'], ENT_QUOTES, 'UTF-8'); ?>"></p>
                        </div>
                        <br><br>
                        <a href="list.php" id="back">戻る</a>
                        <p><input type="submit" value="変更"></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

	<!-- フッタ -->
    <footer>
        <div class="">
            <br><br><hr>
	        <p class="text-center">Copyright (c) HTMQ All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>