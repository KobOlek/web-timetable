<?php
include("./config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>
    
<main class="form-signin w-100 align-self-center d-flex justify-content-center d-flex align-content-center flex-wrap">
  <form method="POST">

    <h1 class="h3 mb-3 fw-normal">Реєстрація</h1>
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingPassword" placeholder="Id" name="id">
      <label for="floatingPassword">Ідентифікатор</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
      <label for="floatingPassword">Пароль</label>
    </div>
    
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Реєстрація!</button>
  </form>
</main>
    <?php 
        
        $password = '';
        $email = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        if(isset($_POST['id'])) {
            $email = $_POST['id'];
        }
        $sql_check_login = "SELECT * FROM users WHERE us_email = '".$email."'";
        $result = $mysqli->query($sql_check_login);
        $resres = $result->fetch_row();
        if(empty($resres)!=1) {
            echo "<h1>Логін вже використовується!</h1>";
        } else {
          $sql_insert = "INSERT INTO users(us_email, us_password, us_user_type) VALUES ('".$email."', '".md5(md5($password))."', 1)";
          $mysqli->query($sql_insert);
          session_start();
          $sql_insert1 = "INSERT INTO sessions(us_email, ss_isActive) VALUES ('".$email."', '".session_id()."')";
          $mysqli->query($sql_insert1);
          $_SESSION["us_email"] = $email;
          header("Location: ../index.php");
        }
      
        }
    ?>
</body>
</html>