<?php
include("config.php");
//include("timetable/tables/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Увійти</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>
<h1 class="text-center">Інормаціна система "Науковий Ліцей імені Богдана Лепкого"</h1>    
<main class="form-signin w-100 align-self-center d-flex justify-content-center d-flex align-content-center flex-wrap ">
  <form method="POST">

    <h1 class="h3 mb-3 fw-normal">Увійти</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name='login' required=''>
      <label for="floatingInput">Ідентифікатор</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required=''>
      <label for="floatingPassword">Пароль</label>
    </div>

    </div>
    <select class="form-select" name="user_type_select" id="">
      <option value="0">Не вибрано(Натисни нижче)</option>
      <option value="3">Учень</option>
      <option value="2">Вчитель</option>
      <option value="1">Admin</option>
    </select>
    <button class="btn btn-primary w-100 py-2" type="submit">Увійти!</button>
  </form>
</main>
    <?php 
        $login = '';
        $password = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        if(isset($_POST['login'])) {
            $login = $_POST['login'];
        }
        $sql_insert = "SELECT * FROM users WHERE us_user_type = ".$_POST["user_type_select"]." AND us_email = $login AND us_password = '".md5($password)."'";
        $result = $mysqli->query($sql_insert);
        $resres = $result->fetch_row();
        if(empty($resres)!=1) {
            session_start();
            $sql_insert = "INSERT INTO sessions(us_email, ss_isActive) VALUES ('".$login."', '".session_id()."')";
            $mysqli->query($sql_insert);
            $_SESSION["us_email"] = $login;
            header("Location: ../index.php");
        }
        else {
          echo "<h2>Невірні дані входу!</h2>";
        } 
      }
    ?>
    <footer class="fixed-bottom">
      <h6>Розроблено гуртком "Інформаційні технології"</h6>
      <p>
        На ЗСУ
        <a href="https://tinyurl.com/mparj88r">https://tinyurl.com/mparj88r</a>
      </p>
    </footer>
</body>
</html>