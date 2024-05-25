<?php
    $dbserver = "db1.ho.ua";
    $dbuser = "root";
    $dbpass = "kjO2oWX1Dn";
    $dbname = "mytestsite";
    $link = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) or die("Error".mysqli_error($link));
    mysqli_query($link, "SET NAMES utf8");

    header("Content-Type: text/html; charset=utf-8");
    $mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
?>