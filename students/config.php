<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timetabledb1";
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn,'SET NAMES utf8');
?>