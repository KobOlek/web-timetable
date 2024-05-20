<script>
function dd()
{
    alert('cddd');
}
</script>

<?php
include("config.php");

if ($conn->connect_error) {
    die("Помилка підключення до бази даних: <br>". $conn->connect_error);
}
//----------------------------------
if (isset($_GET['oth_id']))
{
    $sql = "SELECT oth_name FROM adress_oth where oth_id=".$_GET['oth_id'];
    $result = $conn->query($sql);
    list($oth_name)= $result->fetch_array();
    echo "<a href='adress.php?oth_id=".$_GET["oth_id"]."&addoth=ok'>Додати теротеріальну громаду</a><br>";
}
if (isset($_GET['addoth']))
 {    
    echo "<form method='post' action=''>
    <input type='text' name='inserttext_select' value=''>
    <input type='submit' name='insert_oth' value='insert'>
    </form>";
 }

 if (isset($_POST['insert_oth']))
 {    
     $newName = $_POST['inserttext_select'];   
     $sql = "INSERT INTO adress_oth (oth_name) VALUES ('$newName')";
     if($conn->query($sql) === TRUE){
         echo "Інформація туспішно встановлена.<br>";
     } else {
         echo "Помилка вставки інформації: <br>" . $conn->error;
     }
 }
////////////////////////////////////////////////////////
//операції о отг
if (isset($_POST['delete_select']))
 {
    $searchid=$_GET['oth_id'];
    $sql = "DELETE FROM adress_oth WHERE oth_id=$searchid";
    if ($conn->query($sql) === TRUE)
    {
      echo"інформація про користувача видалено успішно<br>";
    } else {
    echo "Помилка видалення інформації<br>" . $conn->error;}
}

if (isset($_POST['update_select']))
{
    $newName = $_POST['new_select'];
    $userId = $_GET['oth_id'];
    $sql = "UPDATE adress_oth SET oth_name='".$newName."' WHERE oth_id=".$userId;
    echo $sql;
    if($conn->query($sql) === TRUE)
    {
        echo "Інформація успішно оновлена <br>";
    } 
    else 
    {
        echo "Помилка оновлення інформації: <br>" . $conn->error;
    }
}

/////////////////////////////////////////////////////////

$sql = "SELECT oth_id, oth_name FROM adress_oth";
$result = $conn->query($sql);
If($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc()){
        echo "<a href='adress.php?oth_id=".$row["oth_id"]."&editoth=ok'>edit</a>|";
        echo "<a href='adress.php?oth_id=".$row["oth_id"]."'>".$row["oth_name"]."</a><br>";   
    }
} else { "Не знайдено жодного запису <br>";}

if (isset($_GET['oth_id']))
{
    if (isset($_POST['insert_th']))
    {    
        $newName = $_POST['insert_oth_name'];
        $sity_tupe = $_POST['insert_oth_type'];
        $insCityOth = $_GET['oth_id']; 
        $sql = "INSERT INTO adress_city (city_name, city_oth_id, city_type) VALUES ('$newName',$insCityOth,'$sity_tupe')";
        if($conn->query($sql) === TRUE){
            echo "Інформація успішно встановлена. Останеній встановлений ID: <br>";
        } else {
            echo "Помилка вставки інформації: <br>" . $conn->error;
        }
    }
    
    $sql = "SELECT oth_name FROM adress_oth where oth_id=".$_GET['oth_id'];
    $result = $conn->query($sql);
         list($oth_name)= $result->fetch_array();
            echo "Обрано - ".$oth_name."  ";
            echo "<a href='adress.php?oth_id=".$_GET["oth_id"]."&addtooth=ok'>Добавити населений пункт</a><br>";

            if(isset($_GET['editoth']))
    { echo "<form method='post' action=''>";
        echo "<input type='submit' name='delete_select' value='delete'>
 <input type='submit' name='update_select' value='update'>
 <input type='text' name='new_select' value='$oth_name'>
 </form>";
    }
   ///////////////////////////////////////////////////////////////////
    if(isset($_GET['addtooth']))
    {
        echo "<form method='post' action=''>";
        echo "<select name='insert_oth_type' value=''>";
        if ($st_stat==''){echo "<option value='' selected>  </option>";}else{echo "<option value=''>  </option>";}
        if ($st_stat=='село'){echo "<option value='село' selected>село</option>";}else{echo "<option value='село'>село</option>";}
        if ($st_stat=='місто'){echo "<option value='місто' selected>місто</option>";}else{echo "<option value='місто'>місто</option>";}           
        echo "</select>
        <input type='text' name='insert_oth_name' value=''>
        <input type='submit' name='insert_th' value='insert'>
        </form>";
    }
////////////////////////////////////////////////////////////////////////
    if(isset($_GET['edit_sity']))
    {
        if(isset($_GET['edit_sity_th']))
        {
            $newName = $_POST['edit_sity_name'];
            $userId = $_GET['edit_sity'];
            $sql = "UPDATE adress_city SET city_name='".$newName."' WHERE city_id=".$userId;
            echo $sql;
            if($conn->query($sql) === TRUE)
            {
                echo "Інформація успішно оновлена ";
            } 
            else 
            {
                echo "Помилка оновлення інформації: " . $conn->error;
            }
        }

        if(isset($_POST['del_sity_th']))
        {
            $sql = "DELETE FROM adress_city WHERE city_id=".$_GET['edit_sity'];
            echo $sql;
            if($conn->query($sql) === TRUE)
            {
                echo "Інформація успішно видалена";
            } 
            else 
            {
                echo "Помилка видалення інформації:".$conn->error;
            }
        }

        ///////////////////////////////////////////////////////////////
        $sql = "SELECT city_name, city_type FROM adress_city where city_id=".$_GET['oth_id'];
        $result = $conn->query($sql);
        list($city_name,$city_type)= $result->fetch_array();
        echo $city_name.$city_type;
        ///////////////////////////////////////////////////////////////////
        echo "<form method='post' action=''>";
        echo "<select name='st_edit_sity' value=''>";
        if ($city_type==''){echo "<option value='' selected>  </option>";}else{echo "<option value=''>  </option>";}
        if ($city_type=="село"){echo "<option value='село' selected>село</option>";}else{echo "<option value='село'>село</option>";}
        if ($city_type=="місто"){echo "<option value='місто' selected>місто</option>";}else{echo "<option value='місто'>місто</option>";}           
        echo "</select>
        <input type='text' name='edit_sity_name' value='".$city_name."'>
        <input type='submit' name='edit_sity_th' value='update'>
        <input type='submit' name='del_sity_th' value='deleta'>
        </form>";
    }
////////////////////////////////////////////////////////////////////////////////////////
    $sql = "SELECT city_type, city_name, city_id FROM adress_city where city_oth_id=".$_GET['oth_id']." order by city_type, city_name";
    $result = $conn->query($sql);
    If($result->num_rows > 0) {
    $i=1;
        while ($row = $result->fetch_assoc()){
            echo $i;
            echo "<a href='adress.php?oth_id=".$_GET["oth_id"]."&edit_sity=".$row["city_id"]."'>edit</a>  ".$row['city_type']." ".$row['city_name']."<br>";
            $i++;
        }
    } else { "Не знайдено жодного запису";}


    // echo "<a href='adress.php?oth_id=".$row["oth_id"]."'>".$row["oth_name"]."</a><br>";
}

$sql = "SELECT oth_id, oth_name FROM adress_oth order by oth_name";
$result = $conn->query($sql);
echo "<select name='oth' id='oth' onChange='dd()'>";
echo "<option value='0' selected>  </option>";
while ($row = $result->fetch_assoc())
{
  echo "<option value=".$row['oth_id'].">".$row['oth_name']."</option>"; 
}
echo "</select>";


echo "<select name='oth' id='oth0'>";
echo "<option value='0' selected>  </option>";
echo "</select>";


?>