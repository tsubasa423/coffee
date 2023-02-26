<?php
require("./db.php");
session_start();

// 会員登録の手続き以外のアクセスを飛ばす
if (!isset($_SESSION['join'])) {
    header('Location: entry.php');
    exit();
}

if (!empty($_POST['check'])) {
    $hash = password_hash($_SESSION['join']['password'], PASSWORD_BCRYPT); // パスワード暗号化

    // 入力情報登録
    $statement = $db->prepare("INSERT INTO job SET user=?, pass=?");
    $statement->execute(array(
        $_SESSION['join']['user'],
        $hash
    ));

    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thanks.php');  
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="check.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>

</head>
<body>
  <div class="background"></div>
      <form  action="" class="box" method="post" enctype="multipart/form-data">
        <h2>登録確認</h2>
            <input type="hidden" name="check" value="checked">
            <div class="menu">
              <h3>ご入力情報に変更が<br>
                必要な場合、変更を行って<br>ください。<h3>
            </div>

            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>

                <h3>お名前の確認</h3>
                <span class="fas fa-angle-double-right"></span> <span class="check-info">
                <?php echo htmlspecialchars($_SESSION['join']['user'], ENT_QUOTES); ?></span>
                <h3>パスワードの確認</h3>
                <span class="fas fa-angle-double-right"></span> <span class="check-info">
                <?php echo htmlspecialchars($_SESSION['join']['password'], ENT_QUOTES); ?></span>
                <br><br>
            <a href="entry.php" class="back-btn">変更する</a>
            <input type="submit" value="登録">


        </form>
    </div>
</body>
</html>
