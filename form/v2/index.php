<?php
// session_start();
// session_regenerate_id(true);
// if (isset($_SESSION['user'])) $user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="form.css">
    <link rel="stylesheet" href="form.css">
    <title>会員登録フォーム</title>
</head>

<body>
    <form method="post" action="confirm.php" enctype="multipart/form-data">
        <div class="container">
            <h1>会員登録フォーム</h1>
            <div class="element_wrap">
                <label>名前</label>
                <input type="text" name="your_name" maxlength="20" required>
            </div>
            <div class="element_wrap">
                <label>カナ</label>
                <input type="text" name="your_kana" maxlength="20" required>
            </div>
            <div class="element_wrap">
                <label>電話</label>
                <input type="tel" name="phone" pattern="^\d{11}$|^\d{2,4}-\d{3,4}-\d{4}$" required>
            </div>
            <div class="element_wrap">
                <label>メールアドレス</label>
                <input type="email" name="email" required>
            </div>
            <div class="element_wrap">
                <label>生まれ年</label>
                <select name="year">
                    <?php foreach (range(1900, date("Y")) as $year) : ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="element_wrap">
                <label>性別</label>
                <label for="r_male"><input id="r_male" type="radio" name="gender" value="0" checked="checked">男性</label>
                <label for="r_female"><input id="r_female" type="radio" name="gender" value=”1”>女性</label>
            </div>
            <div class="element_wrap">
                <label>メールマガジン送付</label>
                <input type="checkbox" name="magagine" value="1">
            </div>
            <div class="element_wrap">
                <label for="upload">画像選択</label>
                <input type="file" name="upfile" size="30" id="upload">
            </div>
            <input type="submit" name="btn_confirm" value="登録">
    </form>

</body>

</html>