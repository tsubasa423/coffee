<?php
try {
    $db = new PDO('mysql:dbname=coffee;host=localhost;charset=utf8mb4', 'tsubasa', 'ht2058');
}   catch (PDOException $e) {
    echo "データベース接続エラー：".$e->getMessage();
}
?>