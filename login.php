<?php
require('./db.php');
session_start(); 

if(!empty($_POST)) {
    if(($_POST['user'] != '') && ($_POST['password'] != '')) {
        $login = $db->prepare('SELECT * FROM job WHERE user=?');
        $login->execute(array($_POST['user']));
        $member=$login->fetch();

        if(password_verify($_POST['password'],$member['pass'])) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time'] =time();


            header('Location: home.html');
            exit();
        } else {
            $error['login']='failed';
        }
    } else {
        $error['login'] ='blank';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="ニワトリアイコン.ico">
	<link rel="stylesheet" href="login.css">
	<script type="text/javascript" src="login.js"></script>
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<title>ログイン</title>
</head>
<body>
  <div class="background"></div>
	<form  action="" class="box" method="post" enctype="multipart/form-data">
			<h2>ログイン</h2>
			<input type="text" name="user" placeholder="お名前">
			<input type="password" name="password" id="textPassword" placeholder="パスワード">
			<span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()">パスワードを表示する</span>
      <?php if (isset($error['login']) &&  ($error['login'] =='blank')): ?>
        <p class="error">*お名前・パスワードの両方を入力してください</p>
      <?php endif; ?>
      <?php if( isset($error['login']) &&  $error['login'] =='failed'): ?>
        <p class="error">*アカウントが見つかりません</p>
      <?php endif; ?>
			<input type="submit" value="ログイン">
      <a href="entry.php">"会員登録はこちらをClick"</a><br>
	</form>
	</body>
</html>
