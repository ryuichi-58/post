<?php
session_start();

if(!empty($_POST)) {
    // エラー項目の確認
    if ($_POST['name'] == '') {
        $error['name'] = 'blank';
    }
    if ($_POST['email'] == '') {
        $error['email'] = 'blank';
    }
    if (strlen($_POST['password']) < 4) {
        $error['password'] = 'length';
    }
    if ($_POST['password'] == '') {
        $error['password'] = 'blank';
    }
    $fileName = $_FILES['image']['name'];
    if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
            $error['image'] = 'type';
        }
    }
    if (empty($error)) {
        // 画像をアップロードする
        $image = date('YmdHis') . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);

        $_SESSION['join'] = $_POST;
        $_SESSION['join']['image'] = $image;
        header('Location: check.php');
        exit();
    }
}
?>
<p>次のフォームに必要事項をご記入ください。</p>
<form action="" method="post" enctype="multipart/form-data">
<dl>
    <dt>ニックネーム<span class="required">必須</span></dt>
    <dd><input type="text" name="name" size="30" maxlength="255" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>"/>
        <?php if ($error['name'] == 'blank'): ?>
        <p class="error">※ニックネームを正しく入力して下さい</p>
        <?php endif; ?>
    </dd>
    <dt>メールアドレス<span class="required">必須</span></dt>
    <dd><input type="text" name="email" size="30" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"/>
        <?php if ($error['email'] == 'blank'): ?>
        <p class="error">※メールアドレスを正しく入力して下さい</p>
        <?php endif; ?>
    </dd>
    <dt>パスワード<span class="required">必須</span></dt>
    <dd><input type="text" name="password" size="30" maxlength="20" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>"/>
        <?php if ($error['password'] == 'blank'): ?>
        <p class="error">※パスワードを正しく入力して下さい</p>
        <?php endif; ?>
        <?php if ($error['password'] == 'length'): ?>
        <p class="error">※パスワードを4文字以上で入力して下さい</p>
        <?php endif; ?>
    </dd>
    <dt> 画像</dt>
    <dd>
        <input type="file" name="image" size="35" />
        <?php if ($error['image'] == 'type'): ?>
        <p class="error">画像は「.gif」「.jpg」「.png」のいずれかをご指定下さい</p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
        <p class="error">※画像を改めて指定して下さい</p>
        <?php endif; ?>
    </dd>
</dl>
<div><input type="submit" value="入力内容を確認する" /></div>
</form>
