<?php
include("config.php");

if ($conn->connect_error) {
    die("Помилка підключення до бази даних: ". $conn->connect_error);
}

$tupe_user=1; //1-адмін    2-користувач

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="../style.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>            


    <script src="students/js/jquery-1.4.2.js" type="text/javascript"></script>
	<script src="students/js/jquery.jcarousel.js" type="text/javascript"></script>
	<script src="students/js/js-func.js" type="text/javascript"></script>

   <link rel="stylesheet" type="text/css" href="students/fancybox/jquery.fancybox.css" media="screen" />

   <!--<script type="text/javascript" src="fancybox/jquery-1.3.2.min.js"></script>-->
   <script type="text/javascript" src="students/fancybox/jquery.easing.1.3.js"></script>
   <script type="text/javascript" src="students/fancybox/jquery.fancybox-1.2.1.pack.js"></script>
</head>

<script type="text/javascript">
    $(document).ready(function() 
    {
      $("a.gallery, a.iframe,a.iframe2").fancybox();

      $("a.iframe").fancybox(
      {                 
        "frameWidth" : 500,  // ширина окна, px (425px - по умолчанию)
        "frameHeight" : 300 // высота окна, px(355px - по умолчанию)
      }
      );

      $("a.iframe2").fancybox(
      {                 
        "frameWidth" : 800,  // ширина окна, px (425px - по умолчанию)
        "frameHeight" : 600 // высота окна, px(355px - по умолчанию)
      }
      );

    });
</script>

<body>
    <?php
        $a=5;
        if(($tupe_user==1)||($tupe_user==2))
        {
            echo "
            <div align=center>";
            echo "<a class='iframe' href='students/operation.php?stat=ok'>Статистика по класах</a> || ";
            echo "<a class='iframe' href='students/operation.php?adr=ok'>Статистика за місцем проживання</a> || " ;
            echo "<a class='iframe' href='students/operation.php?each=ok'>Пошук учня за ПІБ</a>";
            echo "</div>";
        }

        echo "<div>
        <h1 align=center> Оберіть номер класу </h1>
        <table class='table table-stripped' border=1 align=center><tr>";
        while($a<=12)
        {
            echo "
            <th width=50px height=35px>
            <a href='?menu=students&cl=".$a."'>".$a." класи</a>
            </th>";
            $a++;
        }
        echo "
        </tr><tr>
        <td colspan=8>";
          if(($tupe_user==1)&&(isset($_GET['cl'])))
          {
              echo "<div align=center>";
              echo "<a class='iframe' href='operation.php?cl=".$_GET['cl']."&addclass=ok'>додати клас</a>";
              echo "</div>";

          }  
        echo "</td>
        </tr>
        </table>
        </div>";  
    ?>
    <?php
if (isset($_GET['cl']))
{ 
    $sql = "SELECT cl_id, cl_name FROM class where cl_name like '%".$_GET['cl']."%' order by cl_bukva";
    $result = $conn->query($sql);
    If($result->num_rows > 0) 
    {
        echo "
        <h2 align=center>Оберіть клас</h2>
        <div>
        <table class='table table-stripped' border=1 align=center>  <tr>";

        while ($row = $result->fetch_assoc())
        {
            echo "<th width=50px height=35px>";
            echo   "<a href='?menu=students&cl=".$_GET['cl']."&st=".$row["cl_id"]."'>".$row["cl_name"]." клас</a><br>";
            if($tupe_user==1)
            {
              echo "<a href='?menu=students&cl=".$_GET['cl']."&st=".$row["cl_id"]."&delclass=ok'>x</a> ";
            }
            echo "</th>";
        }    
            echo "</tr></table></div>"; 
           
            if(($tupe_user==1)&&(isset($_GET['st'])))
            { 
                if(isset($_GET['st']))
                {
                    echo "<div align=center>";
                    echo "<a class='iframe' href='students/operation.php?menu=students&st=".$_GET['st']."&insertinclass=ok'>добавити учня</a>";
                    echo "</div>";
                }
            }         
    } else { "Не знайдено жодного запису";}   
}
    ?>
    <?php
if (isset($_GET['st']))
{
    $sql = "SELECT cl_name FROM class where cl_id=".$_GET['st'];
    $result = $conn->query($sql);
    $nameClass = '';
    while ($row = $result->fetch_assoc())
    {
      $nameClass=$row['cl_name'];
    } 
    $sql = "SELECT * FROM stud where st_cl_id=".$_GET['st']." order by st_pib";
        $result = $conn->query($sql);       
        If($result->num_rows > 0) 
         {    
            echo "";            
            echo "<div align=center><p><h3>Учні ".$nameClass." класу </h3></p></div>";
            echo "<div><table class='table table-hover' border=1 align=center>";
            $np=1;
             echo"<tr><th>н/п</th>";
             echo"<th>Прізвище, ім`я</th>";
             echo"<th>ДН</th>";
             echo"<th>стать</th>";
             echo"<th>статус</th>";
             echo"</tr>";
                while ($row = $result->fetch_assoc())
                {
                    echo "<tr><td>";
                       echo $np.".";
                    echo "</td>";
                    echo "<td>";
                if(($tupe_user==1)||($tupe_user==2))
                {
                    echo "<a class='iframe2' href='students/stud.php?menu=students&stud=".$row['st_id']."'>".$row['st_pib']."</a>";   
                }
                else{
                     echo $row['st_pib'];
                }                     
                    echo "</td>";
                    echo "<td>";
                       echo  $row["st_birsday"];  
                    echo "</td>";
                    echo "<td>";
                        echo  $row['st_stat'];  
                    echo "</td>";
                    echo "<td>";
                         echo  $row['st_status'];  
                    echo "</td>";
                     
                 $np++;
                } 
            echo "</tr> </table></div>";   
            } else { "Не знайдено жодного запису";}      
        }
    ?>
</body>
</html>