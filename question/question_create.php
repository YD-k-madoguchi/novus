<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="2.css" />
    <title>質問投稿ページ</title>
</head>
<body>
    
<div>質問したい内容を入力してください</div>

<form method="POST" action="http://localhost/qandasite/question/question_comp.php">
    <div class=""style="text-align: center">
        <div>題名</div>
        <input type="text" name="title" required>
        <br>

        <div>カテゴリ</div>
        <select name="category" required >
            <option></option>
            <option>項目1</option>
            <?php foreach($categories as $value){
                echo "<option>" .$value ."</option>";
            } ?>
        </select>

        <br>
        <div>本文</div>
        <textarea required name="message"></textarea>
        <br>
        <input type="submit" name="create_question">
    </div>
</form>

<?php


?>

    
</body>
</html>