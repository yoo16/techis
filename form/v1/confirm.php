<?php
define("FILE_DIR", "images/");

// サニタイズ
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
}

if (!empty($_FILES['upfile']['tmp_name'])) {
    $upload_res = move_uploaded_file($_FILES['upfile']['tmp_name'], FILE_DIR . $_FILES['upfile']['name']); //ファイルを指定のフォルダへ移動
    if ($upload_res !== true) {
        $error[] = 'ファイルのアップロードに失敗しました。'; //エラー文
    } else {
        $clean['upfile'] = $_FILES['upfile']['name']; //成功したときは分かりやすいように$cleanに格納

        list($width, $hight) = getimagesize(FILE_DIR . $clean['upfile']); // 元の画像名を指定してサイズを取得
        $baseImage = imagecreatefromjpeg(FILE_DIR . $clean['upfile']); // 元の画像から新しい画像を作る準備
        $image = imagecreatetruecolor(100, 100); // サイズを指定して新しい画像のキャンバスを作成

        // 画像のコピーと伸縮
        imagecopyresampled($image, $baseImage, 0, 0, 0, 0, 100, 100, $width, $hight);

        // コピーした画像を出力する
        imagejpeg($image, 'new.jpg');
    }
}

//png に対応する場合
function resizePng($path, $new_path, $resize_with = 100, $resize_height = 100)
{
    list($width, $hight) = getimagesize($path);
    $baseImage = imagecreatefrompng($path);
    $image = imagecreatetruecolor(100, 100);
    imagealphablending($image, false);
    imagesavealpha($image, true);
    imagecopyresampled($image, $baseImage, 0, 0,0, 0, $resize_with, $resize_height, $width, $hight);
    imagepng($image, $new_path);
    imagedestroy($image);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="form.css">
    <title>会員登録フォーム</title>
</head>

<body>
    <form method="post" action="done.php">
        <h1>会員登録フォーム</h1>
        <div class="element_wrap">
            <label>名前</label>
            <p><?php echo $clean['your_name']; ?></p>
        </div>
        <div class="element_wrap">
            <label>カナ</label>
            <p><?php echo $clean['your_kana']; ?></p>
        </div>
        <div class="element_wrap">
            <label>電話</label>
            <p><?php echo $clean['phone']; ?></p>
        </div>
        <div class="element_wrap">
            <label>メールアドレス</label>
            <p><?php echo $clean['email']; ?></p>
        </div>
        <div class="element_wrap">
            <label>生まれ年</label>
            <p><?php echo $clean['year']; ?></p>
        </div>
        <div class="element_wrap">
            <label>性別</label>
            <p>
                <?php
                if ($clean['gender'] == 0) {
                    echo "男性";
                } elseif ($clean['gender'] = 1) {
                    echo "女性";
                };
                ?>
            </p>
        </div>
        <div class="element_wrap">
            <label>メールマガジン送付</label>
            <p>
                <?php
                if (empty($clean['magagine'])) {
                    echo "受け取らない";
                } elseif ($clean['magagine'] = "1") {
                    echo "受け取る";
                };
                ?>
            </p>
        </div>
        <div class="element_wrap">
            <label>画像選択</label>
            <p><?php echo $clean['upfile'] ?></p>
        </div>
        <div class="element_wrap">
            <label></label>
            <p><img src="<?php echo 'new.jpg'; ?>"></p>
        </div>

        <input type="button" onclick="history.back()" name="btn_back" value="戻る">
        <input type="submit" name="btn_submit" value="送信">

        <input type="hidden" name="your_name" value="<?php echo $clean['your_name']; ?>">
        <input type="hidden" name="your_kana" value="<?php echo $clean['your_kana']; ?>">
        <input type="hidden" name="phone" value="<?php echo $clean['phone']; ?>">
        <input type="hidden" name="email" value="<?php echo $clean['email']; ?>">
        <input type="hidden" name="year" value="<?php echo $clean['year']; ?>">
        <input type="hidden" name="gender" value="<?php echo $clean['gender']; ?>">
        <input type="hidden" name="magagine" value="<?php echo $clean['magagine']; ?>">
        <?php if (!empty($clean['upfile'])) : ?>
            <input type="hidden" name="upfile" value="<?php echo $clean['upfile']; ?>">
        <?php endif; ?>
    </form>

</body>

</html>