<?php 
$pageFlg = 0;

if(!empty($_POST['btn_confirm'])) {
  $pageFlg = 1;
} elseif(!empty($_POST['btn-submit'])) {
  $pageFlg = 2;
}

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

header('X-FRAME-OPTIONS:DENT');
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Form</title>
</head>
<body>
  <?php if($pageFlg === 0) : ?>
  <?php
    if(!isset($_SESSION['csrtToken'])) {
      $_SESSION['csrtToken'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['csrtToken'];
  ?>
  <form method="POST" action="index.php">
    name <input type="text" name="name" value="<?php if(!empty($_POST['name'])) {echo h($_POST['name']);}  ?>"><br>
    e-mail <input type="email" name="email" value="<?php if(!empty($_POST['email'])) {echo h($_POST['email']);} ?>"><br>
    <input type="hidden" name="csrf" value="<?php echo $token; ?>">
    <input type="submit" name="btn_confirm" value="確認">
  </form>

  <?php elseif($pageFlg === 1) : ?>
    <?php if($_POST['csrf'] === $_SESSION['csrtToken']) : ?>
    <form method="POST" action="index.php">
      <input type="hidden" name="csrf" value="<?php echo $_POST['csrf']; ?>">
      <input type="hidden" name="name" value="<?php echo h($_POST['name']); ?>">
      <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
      name <?php echo h($_POST['name'], ENT_QUOTES, 'UTF-8'); ?><br>
      e-mail <?php echo h($_POST['email'], ENT_QUOTES, 'UTF-8'); ?><br>
      <input type="submit" name="back" value="戻る">
      <input type="submit" name="btn_confirm" value="送信">
    </form>
    <?php else : ?>
      <p>session error!!</p>
    <?php endif; ?>

  <?php elseif($pageFlg === 2) : ?>
    <?php if($_POST['csrf'] === $_SESSION['csrtToken']) : ?>
      送信画面
    <?php else : ?>
      <p>session error!!</p>
    <?php endif; ?>
  <?php endif ?>
</body>
</html>