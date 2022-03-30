<?php
session_start();
//ファイル読み込み
require_once '../../app/UserLogic.php';

//ログインしているか判定して、していなかったら新規登録画面へ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../userLogin/form.php');
    return;
}
$login_user = $_SESSION['login_user'];

//モーダル処理
if (isset($_POST['mypage'])) {
    //経験値取得処理
    $user_exp = UserLogic::plusEXP();
    $user_data = UserLogic::levelModal();
    return;
}

//画像情報の取得
$showicon = UserLogic::showIcon();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/mypage.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/top.css" />
    <link rel="stylesheet" href="../../CSS/level_anime.css">
    <title>My Page</title>
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
            <li class="top"><a href="home.php">TOPページ</a></li>
            <li><a href="../userEdit/list.php">会員情報 編集</a></li>
            <li><a href="../question/qhistory.php">質問 履歴</a></li>
            <li><a href="../../">記事 履歴</a></li>
            <li><a href="#contact">お問い合わせ</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>
    
    <!--前回のレベルと変化があった際にのみレベルモーダルを表示させる-->
    <?php if ($_SESSION['login_user']['level'] !== $_SESSION['login_user']['pre_level']): ?>
        <!--モーダル-->
        <div id="modal-content">
            <p style="text-align:canter;"><?php require_once 'level_anime.php'; ?></p>
	        <p><a id="modal-close" class="button-link" onclick="modal_onclick_close()" >CLOSE</a></p>
        </div>
        <!-- 2番目に表示されるモーダル（半透明な膜） -->
        <div id="modal-overlay" ></div>
        <!-- JavaScript -->
        <script type="text/javascript">
            function modal_onclick_close(){
            document.getElementById("modal-content").style.display = "none";
            document.getElementById("modal-overlay").style.display = "none";
            }
        </script>
    <?php endif; ?>

    <section class="wrapper">
        <div class="container">
            <div class="content">
                <h2 class="heading">MY ACCOUNT</h2>
                <div class="list">
                    <!--ユーザーが登録した画像を表示-->
                    <div class="list-item">
                        <?php if (isset($login_user['icon'])): ?> 
                            <img src="../user/img/<?php echo $login_user['icon']; ?>">
                        <?php else: ?>
                        <?php echo "<img src="."../user/img/sample_icon.png".">"; ?>
                        <?php endif; ?>
                    </div>
                    <!--ユーザーが登録した名前を表示-->
                    <div class="text">
                        <p class="fw-bold">名前</p>
                        <?php echo htmlspecialchars($login_user['name'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <!--ユーザーの現レベルを表示-->
                    <div class="text">
                        <p class="fw-bold">レベル</p>
                        Lv.<?php
                           if (isset($login_user['level'])) {
                               echo htmlspecialchars($login_user['level'], ENT_QUOTES, 'UTF-8'); 
                           } else {
                               echo '1';
                           } ?>
                    </div>
                    <div class="text">
                        <p class="fw-bold">コメント</p>
                        <p class="text-sm-start text-break small"><?php
                            if (isset($login_user['comment'])) {
                               echo htmlspecialchars($login_user['comment'], ENT_QUOTES, 'UTF-8'); 
                            } else {
                               echo 'Let us introduce yourself!';
                            } ?></p>
                    </div>
                </div>
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