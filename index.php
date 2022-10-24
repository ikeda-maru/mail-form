<?php
  if(!empty($_POST)) {
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
  }
?>

<?php $pageFlg = 0; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Form</title>
</head>
<body>
  <?php if($pageFlg === 0) : ?>
  <form method="POST" action="index.php">
    name <input type="text" name="name"><br>
    e-mail <input type="email" name="email"><br>
    <input type="submit" name="btn_confirm" value="確認">
  </form>

  <?php elseif($pageFlg === 1) : ?>
  <form method="POST" action="index.php">
    <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
    name <?php echo $_POST['name']; ?><br>
    e0mail <?php echo $_POST['email']; ?><br>
    <input type="submit" name="btn_submit" value="送信">
  </form>

  <?php elseif($pageFlg === 2) : ?>
    送信完了
  <?php endif; ?>

</body>
</html>