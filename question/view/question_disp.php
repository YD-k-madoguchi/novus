<?php

  session_start();

  //ファイルの読み込み
  require_once '../../classes/QuestionLogic.php';
  require_once '../../classes/UserLogic.php';

  //error
  $err = [];

  $question_id = filter_input(INPUT_GET, 'question_id');

  if(!$question_id = filter_input(INPUT_GET, 'question_id')) {
    $err[] = '質問を選択し直してください';
  }

  if (count($err) === 0){
    //質問を引っ張る処理
    $question = QuestionLogic::displayQuestion($_GET);
    $answer = QuestionLogic::displayAnswer($_GET);

    if(!$question){
      $err['question'] = '質問の読み込みに失敗しました';
    }
    if(!$answer){
      $err['answer'] = '返信の読み込みに失敗しました';
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/7bf203e5c7.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="2.css" />
  <link rel="stylesheet" type="text/css" href="../../css/mypage.css" />
  <link rel="stylesheet" type="text/css" href="../../css/top.css" />
  <link rel="stylesheet" type="text/css" href="../../css/question.css" />
  <title>質問表示</title>
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
            <li class="top"><a href="login_top.php">TOP Page</a></li>
            <li><a href="../userEdit/edit_user.php">My Page</a></li>
            <li><a href="#">TO DO LIST</a></li>
            <li><a href="../../question/view/qhistory.php">質問 履歴</a></li>
            <li><a href="../../">記事 履歴</a></li>
            <li>
                <form type="hidden" action="logout.php" method="POST">
				    <input type="submit" name="logout" value="ログアウト" id="logout" style="text-align:left;">
                </form>
            </li>
        </ul>
    </header>

    <!--コンテンツ-->
    <section class="wrapper">
        <div class="container">
            <div class="content">
                <!--質問の詳細表示-->
                <?php if(isset($err['question'])):  ?>
                    <?php echo $err['question'] ?>
                <?php endif; ?>
                <p class="h4 pb-3">詳細表示</p>
                <!--アイコン-->
                <div class="pb-1 small">
                    <?php if(!isset($question['icon'])): ?>
                      <?php echo $question['post_date']  ?>
                    <?php else: ?>
                      <img src="../../top/img/<?php echo $question['icon']; ?>">
                    <?php endif; ?>
                </div>
                <!--投稿者-->
                <div class="pb-4 small">投稿者：
                    <?php echo $question['name'] ?>
                </div>
                <!--題名-->
                <div class="fw-bold pb-1">題名</div>
                    <div><?php echo $question['title'] ?></div>
                <!--カテゴリー-->
                <div class="fw-bold pt-3 pb-1">カテゴリ</div>
                    <div><?php echo $question['category_name'] ?></div>
                <!--本文-->
                <div class="fw-bold pt-3 pb-1">本文</div>
                    <div><?php echo htmlspecialchars($question['message'], \ENT_QUOTES, 'UTF-8') ?></div>
                <!--日付-->
                <div class="pt-4 pb-1 small">投稿日時：
                    <?php if (!isset($question['upd_date'])): ?>
                        <?php echo $question['post_date']  ?>
                    <?php else: ?>
                        <?php echo $question['upd_date'] ?>
                    <?php endif; ?>
                </div>

                <!--投稿者本人の場合、編集削除機能が表示される-->
                <?php if($_SESSION['login_user']['user_id'] == $question['user_id']): ?>
                  <form method="POST" name="question" action="question_edit.php" id="qedit">
                      <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                      <i class="fa-solid fa-pen"><input type="submit" id="edit" value="編集"></i>
                  </form>
                  <form method="POST" name="question" action="question_delete.php" id="qdelete" >
                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                    <i class="fa-solid fa-trash-can"><input type="submit" id="delete" value="削除"></i>
                  </form>
                <?php endif; ?>
                <!--質問の回答があれば表示-->
                <?php if(!empty($answer)): ?>
                    <?php if(isset($err['answer'])):  ?>
                        <?php echo $err['answer'] ?>
                    <?php endif; ?>
                    <?php foreach($answer as $value){ ?>
                        <?php $likes = QuestionLogic::displayLike($value['answer_id']); ?>
                        <div>名前：<?php echo $value['name'] ?></div>
                        <div>アイコン：
                            <?php if(!isset($value['icon'])): ?>
                                <?php echo $value['answer_date']  ?>
                            <?php else: ?>
                                <?php echo $value['icon'] ?>
                            <?php endif; ?>
                        </div>
                        <div>本文：<?php echo htmlspecialchars($value['message'], \ENT_QUOTES, 'UTF-8') ?></div>
                        <div>
                            <?php if (!isset($value['upd_date'])): ?>
                                投稿：<?php echo $value['answer_date']  ?>
                            <?php else: ?>
                                更新：<?php echo $value['upd_date'] ?>
                            <?php endif; ?>
                        </div>
                        <div>いいね数：<?php echo count($likes) ?></div>
                        <?php if($value['best_flg']): ?>
                            <div>ベストアンサー選択されてます！！！！！</div>
                        <?php endif; ?>
                        <?php if($_SESSION['login_user']['user_id'] == $question['user_id'] && $question['best_select_flg'] == 0 && $_SESSION['login_user']['user_id'] != $value['user_id']  ): ?>
                        <form method="POST" action="best_answer.php">
                            <input type="hidden" name="question_id" value="<?php echo $question_id ?>">
                            <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
                            <input type="submit" value="ベストアンサー">
                        </form>
                        <?php endif; ?>
          
                        <?php if($_SESSION['login_user']['user_id'] == $value['user_id']): ?>
                            <form method="POST" action="answer_edit.php">
                                <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
                                <input type="submit" name="a_edit" value="編集">
                            </form>
                            <form method="POST" action="answer_delete.php">
                                <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                <input type="hidden" name="answer_id" value="<?php echo $value['answer_id'] ?>">
                                <input type="submit" name="a_edit" value="削除">
                            </form>
                        <?php endif; ?>
                        <div>----------------</div>
                    <?php }; ?>
                <?php endif; ?>
                <br><br><br>
                <form method="POST" action="answer_create_conf.php" id="a_message">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user']['user_id']; ?>">
                    <input type="hidden" name="question_id" value="<?php echo $question['question_id'] ?>">
                    <textarea placeholder="ここに返信を入力してください" name="a_message" class="w-75" rows="3"></textarea>
                    <br><input type="submit" class="btn btn-warning mt-2" value="返信">
                </form>
                <button type="button" class="mb-4 mt-3 btn btn-outline-dark" onclick="location.href='question_search.php'">戻る</button>
            </div>
        </div>
    </form>

    <!-- フッタ -->
    <footer class="h-10"><hr>
		    <div class="footer-item text-center">
		    	  <h4>Q&A SITE</h4>
		    	  <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
		    			  <a class="nav-link small" href="#">記事</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">質問</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">本検索</a>
		    		</li>
		    		<li class="nav-item">
		    			  <a class="nav-link small" href="#">お問い合わせ</a>
		    		</li>
		    	</ul>
		    </div>
		  <p class="text-center small mt-2">Copyright (c) HTMQ All Rights Reserved.</p>
	</footer>
</body>
</html>