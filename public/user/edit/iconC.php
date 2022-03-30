<?php

session_start();

//ファイル読み込み
require_once '../../../app/UserLogic.php';
require_once '../../../functions.php';

//エラーメッセージ
$err = [];

//ログインしているか判定して、していなかったらログインへ移す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインして下さい';
    header('Location: ../register/form.php');
    return;
}
$login_user = $_SESSION['login_user'];

if (isset($_POST['formcheck'])) {
    $_SESSION['iconEdit'] = $_FILES['icon'];
    $icon = filter_input(INPUT_POST, 'icon');

    if(isset($_FILES['icon'])) {
        // ファイル関連の取得
        $icon = $_FILES['icon'];
        $filename = basename($icon['name']);
        $tmp_path = $icon['tmp_name'];
        $filesize = $icon['size'];
        //ファイル名を使用して保存先ディレクトリを指定 
        //basename()でファイルシステムトラバーサル攻撃を防ぐ
        $save = '../img/' . basename($_FILES['icon']['name']);
        // 拡張は画像形式か
        $allow_ext = array ('jpg', 'jpeg', 'png');
        $file_ext = pathinfo ($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($file_ext), $allow_ext)) {
            $err['icon'] = '画像ファイルを添付してください';
        }
        if (count($err) === 0) {
        //move_uploaded_fileで、一時ファイルを保存先ディレクトリに移動させる
        move_uploaded_file($_FILES['icon']['tmp_name'], $save);
        }
    } 
}

//エラーがなかった場合の処処理
if (count($err) === 0 && (isset($_POST['check']))) {
    
    //ユーザーを登録する
    $userEdit = UserLogic::editUserIcon($_SESSION);
    header('Location: complete.php');
    //既に存在しているアカウントの場合
    if(!$userEdit){
    $err[] = '更新に失敗しました';
    }
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
    <title>変更確認画面[icon]</title>
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
                <form action="" method="POST">
                    <input type="hidden" name="check" value="checked">
                    <h1 class="my-3 h1" style="text-align:center;">入力情報の確認</h1>
                    <p class="my-2" style="text-align:center;">ご入力内容に変更が必要な場合は、下記の<br>ボタンを押して、変更を行ってください。</p>
                    <?php if (!empty($err) && $err === "err"): ?>
                        <p class="err">＊会員情報更新に失敗しました。</p>
                    <?php endif ?>
                    <div class="list">
                        <!--ユーザーが登録したアイコンを表示-->
                        <div class="text">
                            <label for="icon">[Icon]</label>
                            <p><span name="icon" class="check-info"><?php echo $_SESSION['iconEdit']['name']; ?></span></p>
                            <!--未記入時のエラーメッセージ表示-->
                            <?php if (isset($err['icon'])) : ?>
                                <p class="text-danger"><?php echo $err['icon']; ?></p>
                            <?php endif; ?>
                        </div>
                        <!--エラーが発生した場合、メッセージと戻る画面を作成-->
                        <?php if (count($err) > 0) :?>
                        <div class="col-4 bg-secondary">
                            <a href="../edit/icon.php" class="back-btn text-white">再入力する</a>
                        </div>
                        <?php else :?>
                        <div class="text-center">
                            <a href="../edit/icon.php" class="p-2 text-white bg-secondary">戻る</a>
                            <p><button type="submit">変更</button></p>
                        </div>
                        <?php endif ?>
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