<?php
    $dbserver = "";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "timetabledb1";
    $link = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname) or die("Error".mysqli_error($link));
    mysqli_query($link, "SET NAMES utf8");
?>