<link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="../style.css" rel="stylesheet">
<script src="../js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>            

<?php
include("../Auth/config.php");

if (isset($_GET['delclass']))
{
    $searchid=$_GET['st'];
    $sql = "DELETE FROM class WHERE cl_id=$searchid";
    if ($mysqli->query($sql) === TRUE)
    {
        echo"інформація про користувача видалено успішно";
    } else {
        echo "Помилка видалення інформації" . $mysqli->error;
    }
}

if (isset($_POST['delete']))        
{    
    $sql = "DELETE FROM stud WHERE st_id=".$_GET['stud_id'];
    //echo $sql;
    $result = $mysqli->query($sql);                
}
//=============================================================
if (isset($_POST['insert_in_class']))
{    
    $newName = $_POST['insert_st_pib']; 
    $newBirthday = $_POST['insert_st_birsday'];
    $st_stat=$_POST['ins_stat'];
    $ins_status=$_POST['ins_status'];
    $sql = "INSERT INTO stud (st_pib, st_birsday, st_cl_id, st_stat, st_status) VALUES ('".$newName."','".$newBirthday."',".$_GET['st'].",'".$st_stat."','".$ins_status."')";     
    if($mysqli->query($sql) === TRUE){
        echo "Інформація туспішно встановлена. Останеній встановлений ID: ";
    } else {
        echo "Помилка вставки інформації: " . $mysqli->error;
    }
}
//=====================================================================
if (isset($_POST['insert_class']))
{   
    $sql = "INSERT INTO class (cl_name) VALUES ('".$_POST['insert_name_class']."')";
    if($mysqli->query($sql) === TRUE){
        echo "Інформація туспішно встановлена. Останеній встановлений ID: ";
    } else {
        echo "Помилка вставки інформації: " . $mysqli->error;
    }
}
//==========================================================================

 if (isset($_GET['insertinclass']))
 {
       $sql = "SELECT cl_name FROM class where cl_id=".$_GET['st'];
       $result = $mysqli->query($sql);
       $nameClass = '';
       list($nameClass) = $result->fetch_array();

        echo "<b>Режим вставки запису про учня в клас $nameClass</b>";
        echo "<form action='' method='post'>";
        echo "<table class='table table-stripped' border=1>"; 
        echo "<th>назва</th>";
        echo "<th>поле</th>";
        echo "<tr>";
        echo "<td>";
        echo "прізвище, імя";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='insert_st_pib' value=''>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "дата народження";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='insert_st_birsday' required pattern='\d{2}-\d{2}-\d{4}' value='' min='01-01-2000' max='31-12-2099'><br>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "стать";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<select name='ins_stat'>
        <option>  </option>
        <option value='ч'>ч</option>
        <option value='ж'>ж </option>
         </select>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "статус";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<select name='ins_status'>
        <option value='навчається'> навчається </option>
        <option value='за кордоном'> за кордоном </option>
        <option value='вибув'> вибув</option>
         </select>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<input type='submit' name='insert_in_class' value='Добавити'>"; 
        echo "</form>";             
 }
/////////////////////////////////////////////////////////////////////////////////////////////////////
 if(isset($_GET['addclass']))
 {   
   echo "<div align=center>";
   echo "<b>Добавити ".$_GET['cl']." клас</b>";         
   echo "<form action='' method='post'>";
   echo "<input type='text' name='insert_name_class' value='' maxlenght='10' size='10'>";
   echo "<input type='submit' name='insert_class' value='insert_class'>";
   echo "</form>";
   echo "</div>";     
 }   
//////////////////////////////////////////////////////////////////////////////////////////////////////
 if(isset($_GET['each']))
 {
    echo "<div align=center>";
    echo "<b>Пошук учнів</b>";         
    echo "<form action='' method='post'>";
    echo "<input type='text' name='text_each' value=''> ";
    echo "<input type='submit' name='but_each' value='Знайти'>";
    echo "</form>";
    echo "</div>";  
    
    if(isset($_POST['but_each']))
    {
        echo "<div align=center>";
         echo "По пошуковій фразі знайдено: ".$_POST['text_each']; 
        echo "</div>"; 

        $sql = "SELECT st_pib, cl_name FROM class, stud where st_pib like '%".$_POST['text_each']."%' and st_cl_id=cl_id";
        //echo $sql;
        $result = $mysqli->query($sql);

        If($result->num_rows > 0)
        {
            $i=1;
            echo "<div align=center><table class='table table-stripped' border=1 width=100%>";
            while($nameClass = $result->fetch_array())
            {
                echo "<tr>";
                 echo "<td>".$i."</td>";          
                 echo "<td>".$nameClass['cl_name']."</td>";
                 echo "<td>".$nameClass['st_pib']."</td>";       
                echo "</tr>"; 
                $i++;     
            }
            echo "</table></div>";
        }
        else
        {
           echo "<div align=center>";
            echo "Нічого не знайдено"; 
           echo "</div>"; 
        }
    }
 } 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
 if(isset($_GET['stat']))
 {
   echo "<div align=center>";
   echo "СТАТИСТИКА ПО УЧНЯХ"; 
   echo "</div>";
   $sql = "SELECT distinct cl_num FROM class order by cl_num";
   //echo $sql;
   $result = $mysqli->query($sql);
       echo "<div align=center><table class='table table-stripped' border=1 width=100%>";
       echo "<tr>";       
       echo "<th>#</td>"; 
       ////////////////////
       $sql0 = "SELECT distinct cl_bukva FROM class order by cl_bukva";
       $result0 = $mysqli->query($sql0);
       while($nameClass0 = $result0->fetch_array())
       {     
          echo "<th>".$nameClass0['cl_bukva']."</th>";   
       }
       echo "<th>ВСЬОГО</th>"; 
       ///////////////////  
       echo "</tr>";
       while($nameClass = $result->fetch_array())
       {
           echo "<tr>";       
            echo "<th>".$nameClass['cl_num']."</td>";  

            $sql10 = "SELECT distinct cl_bukva FROM class order by cl_bukva";
            $result10 = $mysqli->query($sql10);
            while($nameClass10 = $result10->fetch_array())
            {  
                $sql_c = "SELECT count(*) FROM class, stud where cl_num=".$nameClass['cl_num']." and cl_bukva='".$nameClass10[0]."' and st_cl_id=cl_id";
                $result_c = $mysqli->query($sql_c);
                while($nameClass_c = $result_c->fetch_array())
                {    
                   echo "<td align=center>".$nameClass_c[0]."</td>";  
                }             
            }
            //всього по класах
            $sql_total = "SELECT count(*) FROM class, stud where cl_num=".$nameClass['cl_num']." and st_cl_id=cl_id";
            $result_total = $mysqli->query($sql_total);
            while($nameClass_total = $result_total->fetch_array())
            {    
                echo "<td align=center>".$nameClass_total[0]."</td>";  
            }
           echo "</tr>";   
       }
       echo "</table></div>";
}
?>