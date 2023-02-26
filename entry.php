<?php
require('./db.php');
session_start();

if (!empty($_POST)) { //エラー確認
  
  if ($_POST['user'] == '') {
    $error['user'] = 'blank';
  }

  if ($_POST['password'] == '') {
    $error['password'] = 'blank';
  }

  //重複確認
    if (!isset($error)) {
        $member = $db->prepare('SELECT COUNT(*) as cnt FROM job WHERE user=?');
        $member->execute(array(
            $_POST['user']
        ));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['user'] = 'duplicate';
        }
    }

  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="entry.css">
	<script type="text/javascript" src="login.js"></script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<title>会員登録</title>
</head>
<body>
  <div class="background"></div>
	<form  action="" class="box" method="post" enctype="multipart/form-data">
			<h2>会員登録</h2>
			<input type="text" name="user" placeholder="お名前">
			<?php if (!empty($error["user"]) && $error['user'] === 'blank'): ?>
				<p class="error">＊お名前を入力してください</p>
      <?php elseif (!empty($error["user"]) && $error['user'] === 'duplicate'): ?>
        <p class="error">＊このお名前は既に登録済みです</p>
      <?php endif ?>
			<input type="password" name="password" id="textPassword" placeholder="パスワード">
			<span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()">パスワードを表示する</span>
			<?php if (!empty($error["password"]) && $error['password'] === 'blank'): ?>
        <p class="error">＊パスワードを入力してください</p>
        <?php endif ?>
			<input type="submit" value="登録"><br>
		</form>
		</body>
</html>
