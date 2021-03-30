<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('PHPMailer/src/PHPMailer.php');
require('PHPMailer/src/Exception.php');
require('PHPMailer/src/SMTP.php');

define("FILE_DIR", "images/");

//TODO session
// session_start();
// session_regenerate_id(true);
// if (isset($_SESSION['user'])) $user = $_SESSION['user'];

//サニタイズなし？

//TODO config & public class
$database = 'TECHIS';
$host = 'localhost';
$username = 'root';
$password = ''; //Mac: '', Windows: 'root'
$dsn = "mysql:host={$host};dbname={$database};charset=utf8";

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "DB connect error: " . $e->getMessage() . PHP_EOL;
    exit;
}

$stmt = $dbh->prepare(
    "INSERT INTO (NAME, KANA, TEL, MAIL, YEAR, SEX, MAGAGINE) VALUES(:NAME, :KANA, :TEL, :MAIL, :YEAR, :SEX, :MAGAGINE)"
);

//TODO array bind
//TODO rename column
$stmt->bindValue(':NAME', $_POST['your_name'], PDO::PARAM_STR);
$stmt->bindValue(':KANA', $_POST['your_kana'], PDO::PARAM_STR);
$stmt->bindValue(':TEL', $_POST['phone'], PDO::PARAM_STR);
$stmt->bindValue(':MAIL', $_POST['email'], PDO::PARAM_STR);
$stmt->bindValue(':YEAR', (int)$_POST['year'], PDO::PARAM_INT);
$stmt->bindValue(':SEX', (int)$_POST['gender'], PDO::PARAM_INT);
$stmt->bindValue(':MAGAGINE', (int)$_POST['magagine'], PDO::PARAM_INT);
$stmt->execute();

//TODO Model or setting
if ($_POST['gender'] == 0) {
    $gender = '男性';
} elseif ($_POST['gender'] == 1) {
    $gender = '女性';
}

$mail = new PHPMailer(true);

// 文字エンコードを指定
$mail->CharSet = 'utf-8';

try {
    $mail->SMTPDebug = 0;  // デバグの出力を有効に（テスト環境での検証用）
    $mail->isSMTP();   // SMTP を使用
    $mail->Host       = 'smtp.gmail.com';  // ★★★ Gmail SMTP サーバーを指定
    $mail->SMTPAuth   = true;   // SMTP authentication を有効に
    $mail->Username   = '';  // ★★★ Gmail ユーザ名
    $mail->Password   = '';  // ★★★ Gmail パスワード
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ★★★ 暗号化（TLS)を有効に
    $mail->Port = 587;  //★★★ ポートは 587

    $mail->setFrom('', '差出人名');  //★★★ 差出人メールアドレス & 差出人名
    // 受信者アドレス, 受信者名（受信者名はオプション）
    $mail->addAddress($_POST['email'], '受信者名');
    //コンテンツ設定
    $mail->isHTML(false);   // HTML形式を指定
    //メール表題（文字エンコーディングを変換）
    $mail->Subject = '会員仮登録完了のお知らせ';
    //HTML形式の本文（文字エンコーディングを変換）

    $mail->Body = <<<EOT
会員の仮登録しました。
以下の情報で登録いたします。
名前: {$_POST['your_name']}
カナ: {$_POST['your_kana']}
電話: {$_POST['phone']}
Email: {$_POST['email']}
生まれ: {$_POST['year']}
性別: {$gender}
EOT;

    $mail->AddAttachment(FILE_DIR . $_POST['upfile']);

    $mail->send();  //送信

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録フォーム</title>
</head>

<body>
    <h1>会員登録フォーム</h1>
    <p>会員登録ありがとうございました。</p>
</body>

</html>