<?php 
header('X-FRAME-OPTIONS:DENT');
session_start();

require_once('validation.php');
$errors = validation($_POST);

$pageFlg = 0;

if(!empty($_POST['btn_confirm']) && empty($errors)) {
  $pageFlg = 1;
} elseif(!empty($_POST['btn_submit'])) {
  $pageFlg = 2;
}

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Form</title>
</head>
<body>
  <?php if ($pageFlg === 0) : ?>
  <?php
    // validation
    if(!empty($errors) && !empty($_POST['btn_confirm'])) {
      echo "<ul>";
      foreach($errors as $error) {
        echo '<li>' . $error . '</li>';
      }
      echo "</ul>";
    }

    if(!isset($_SESSION['csrtToken'])) {
      $_SESSION['csrtToken'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['csrtToken'];
  ?>
  <form method="POST" action="index.php">
    <input type="hidden" name="csrf" value="<?php echo $token; ?>">
    name
    <input type="text" name="name" value="<?php if(!empty($_POST['name'])) {echo h($_POST['name']);}  ?>"><br>
    e-mail
    <input type="email" name="email" value="<?php if(!empty($_POST['email'])) {echo h($_POST['email']);} ?>"><br>
    website
    <input type="url" name="url" value="<?php if(!empty($_POST['url'])) {echo h($_POST['url']); } ?>"><br>
    gender
    <input type="radio" name="gender" value="0" <?php if(isset($_POST['gender']) && $_POST['gender'] === '0') {echo 'checked';} ?>>man
    <input type="radio" name="gender" value="1" <?php if(isset($_POST['gender']) && $_POST['gender'] === '1') {echo 'checked';} ?>>woman<br>
    age
    <select name="age">
      <option value="">Please make a selection.</option>
      <option value="1">Under 20 years old</option>
      <option value="2">20 to 29 years old</option>
      <option value="3">30 to 39 years old</option>
      <option value="4">40 to 49 years old</option>
      <option value="5">Over 50 years old</option>
    </select><br>
    contact
    <textarea name="contact">
      <?php if(!empty($_POST['contact'])) {echo h($_POST['contact']); } ?>
    </textarea><br>
    <input type="checkbox" name="caution" value="1">Check<br>
    <input type="submit" name="btn_confirm" value="確認">
  </form>

  <?php elseif($pageFlg === 1) : ?>
    <?php if($_POST['csrf'] === $_SESSION['csrtToken']) : ?>
    <form method="POST" action="index.php">
      <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
      <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
      <input type="hidden" name="url" value="<?php echo $_POST['url']; ?>">
      <input type="hidden" name="gender" value="<?php echo $_POST['gender']; ?>">
      <input type="hidden" name="age" value="<?php echo $_POST['age']; ?>">
      <input type="hidden" name="contact" value="<?php echo $_POST['contact']; ?>">
      <input type="hidden" name="csrf" value="<?php echo $_POST['csrf']; ?>">
      name <?php echo h($_POST['name']); ?><br>
      e-mail <?php echo h($_POST['email']); ?><br>
      website <?php echo h($_POST['url']); ?><br>
      gender
      <?php 
        if($_POST['gender'] === '0') {
          echo 'man';
        } elseif ($_POST['gender'] === '1') {
          echo 'woman';
        }
      ?>
      <br>
      age
      <?php
        if($_POST['age'] === '1') {
          echo 'Under 20 years old';
        } elseif ($_POST['age'] === '2') {
          echo '20 to 29 years old';
        } elseif ($_POST['age'] === '3') {
          echo '30 to 39 years old';
        } elseif ($_POST['age'] === '4') {
          echo '40 to 49 years old';
        } elseif ($_POST['age'] === '5') {
          echo 'Over 50 years old';
        }
      ?>
      <br>
      contact <?php echo h($_POST['contact']); ?><br>
      <input type="submit" name="back" value="戻る">
      <input type="submit" name="btn_submit" value="送信">
    </form>

    <?php else : ?>
      <p>session error!!</p>
    <?php endif; ?>

  <?php elseif($pageFlg === 2) : ?>
      送信画面
  <?php endif; ?>
</body>
</html>