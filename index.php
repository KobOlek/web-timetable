<?php
    include ('config.php');
    include ("tables/functions.php");
    include("Auth/funcs/avatar.php");
?>
<!DOCTYPE html>
<?php

session_start();

list($session) = mysqli_fetch_array(
    selectData("*", "sessions", "WHERE us_email='".$_SESSION['us_email']."'")[0]
);

if($session == null)
{
    redirectTo("auth/login.php");
}

if(!isset($_SESSION['dark-theme'])) 
{
  $_SESSION['dark-theme'] = 'light';
  $_SESSION['dark-checked'] = "no";
}

if(isset($_SESSION['us_email'])) 
{
    $result = selectData("*", "sessions", "WHERE ss_isActive = '".session_id()."'")[0];
    $resres = $result->fetch_row();

    if(array_key_exists('logout', $_POST)) 
    {
        deleteData("sessions", "WHERE us_email='".$_SESSION['us_email']."'");
        header("Location: index.php");
        die();
    }
    if(array_key_exists("change_pass", $_POST)) 
    {
        $sql_insert = "UPDATE users SET us_password ='".(md5(md5($_POST['password'])))."' WHERE us_email = ".$_SESSION['us_email'];
        $mysqli->query($sql_insert);
    }
}

echo "<html lang='en' data-bs-theme='".$_SESSION['dark-theme']."'>";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>            
    
    <title>Main</title>
</head>
<body>
    <?php
        $first_class_number = 5;
        $last_class_number = 12;
        include("Auth/auth.php");
        if(isset($_GET["menu"]) == false)
            include("timetable.php");
    ?>
</body>
</html>