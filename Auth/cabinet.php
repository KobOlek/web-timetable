<?php
include("config.php");
include("funcs/avatar.php");
session_start();
if(!isset($_SESSION['dark-theme'])) {
  $_SESSION['dark-theme'] = 'light';
  $_SESSION['dark-checked'] = "no";
}
if(isset($_SESSION['us_email'])) {
$sql_insert = "SELECT * FROM sessions WHERE ss_isActive = '".session_id()."'";
$result = $mysqli->query($sql_insert);
$resres = $result->fetch_row();
if(array_key_exists('logout', $_POST)) {
    $sql_insert = "DELETE FROM sessions WHERE us_email='".$_SESSION['us_email']."'";
    $mysqli->query($sql_insert);
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
if(array_key_exists("change_pass", $_POST)) {
  $sql_insert = "UPDATE users SET us_password ='".(md5(md5($_POST['password'])))."' WHERE us_email = ".$_SESSION['us_email'];
  $mysqli->query($sql_insert);

  $sql_insert = "DELETE FROM sessions WHERE us_email='".$_SESSION['us_email']."'";
  $mysqli->query($sql_insert);
  session_unset();
  session_destroy();
  header("Location: ../index.php");
}
if(array_key_exists("change-theme", $_POST)) {
    $_SESSION['dark-theme'] = $_POST['dark-theme'];
    $_SESSION['dark-checked'] = ($_POST["dark-theme"] == "dark") ? "yes": "no";
    header("Location: ../index.php");
}
}else {
  header("Location: ../index.php");
};
?>
<!DOCTYPE html>
<?php
echo "<html lang='en' data-bs-theme='".$_SESSION['dark-theme']."'>"
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабінет</title>
    <link href="../style.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<header class="p-3 mb-3 border-bottom">
      <div class="container" style="width:100%">
        <div class="d-flex flex-wrap align-items-left justify-content-left justify-content-lg-end">
          <ul class="nav nav-pills bd-highlight flex-grow-1">
            <li class="mr-auto bd-highlight"><a href="../index.php" class="nav-link active" aria-current="page">Домашня</a></li>
          </ul>
          <?php
          if(!empty($resres)) {
              $sql_init = "SELECT * FROM student WHERE s_us_id = '".$_SESSION['us_email']."'";
              $query = $mysqli->query($sql_init);
              $result = $query->fetch_row()[1];
              echo '
          <div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle show" data-bs-toggle="dropdown" aria-expanded="true">
              <div class="initials-avatar large" 
              style="background: '.getColor($result).';">
                  '.getCapitals($result).'
              </div>
            </a>
            <form method="POST" id="DropDown">
            <ul class="dropdown-menu text-small" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 34px);" data-popper-placement="bottom-start">
              <li><a class="dropdown-item" href="cabinet.php">Мій кабінет</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><button type="submit" name="logout" class="btn btn-outline-primary me-2 mx-2">Вийти</button></li>
            </ul>
            <input type="submit" style="display:none" name="logout" id="logout">
            </form>
          </div>';
          } else {
            echo '<a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Увійти</button></a>';
            echo '<a href="register.php"><button type="button" class="btn btn-primary">Регістрація</button></a>';
          }
        ?>
        </div>
      </div>
    </header>
    <form method="POST" style="height:100%; display:flex; justify-content:center; align-items:center;">
    <summary'>Змінити пароль</summary>
            <input style="display:flex" type="password" class="form-control" id="floatingPassword" placeholder="Новий пароль" name="password" required>
            <button style="display:flex" type="submit" name="change_pass" class="btn btn-outline-primary me-2 my-2">Змінити пароль</button>
        </details></form>
    </form>
    <form method="POST">
    <input type="radio" id="light" name = "dark-theme" value = "light" <?php echo ($_SESSION['dark-checked']=='no')?'checked':''?>>
    <label for="light">Світла тема</label>
    <input type="radio" id="light" name = "dark-theme" value = "dark" <?php echo ($_SESSION['dark-checked']=='yes')?'checked':''?>>
    <label for="light">Темна тема</label>
    <button type="submit" name="change-theme" class="btn btn-outline-primary me-2 mx-2">Примінити</button></form>
    </form>
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>