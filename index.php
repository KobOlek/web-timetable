<?php
    include ('config.php');
    include ("tables/functions.php");
    include("Auth/funcs/avatar.php");
?>
<!DOCTYPE html>
<?php

session_start();
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
    ?>
    <div style="text-align: center;">
        <h3>Оберіть номер класу</h3>
        <table align="center" width="900px" border='1'>
            <tr>
                <?php
                    for($class_number=$first_class_number; $class_number <= $last_class_number; $class_number++)
                    {
                        if(isset($_GET["class"]))
                        {
                            if($class_number == $_GET["class"])
                            {
                                echo "
                                    <th>
                                        <a style='font-size:25px;' href='?class=$class_number'>$class_number</a>
                                    </th>";      
                            }
                            else
                            {
                                echo "
                                    <th>
                                        <a href='?class=$class_number'>$class_number</a>
                                    </th>";
                            }
                        }
                        else
                        {
                            echo "
                                <th>
                                    <a href='?class=$class_number'>$class_number</a>
                                </th>";
                        }
                    }
                ?>
            </tr>
        </table>
    </div>
    <?php
        if(isset($_GET["class"]))
        {
        ?>
            <div style="text-align: center;">
                <h3>Знайдено такі класи</h3>
                <table align="center" width="900px" border='1'>
                    <tr>
                        <?php
                            $class_names = selectData("c_id, c_name", "classes", "WHERE c_name LIKE '%".$_GET['class']."%'")[0];
                            if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                            {
                                while($class_name = mysqli_fetch_array($class_names))
                                {
                                    echo "
                                    <th>
                                        <a href='?class=".$_GET["class"]."&classId=".$class_name["c_id"]."'>".$class_name["c_name"]."</a>
                                    </th>";      
                                }
                            }else
                            {
                                echo "
                                <th>
                                    Записи відсутні
                                </th>";
                            }
                        ?>
                    </tr>
                </table>
            </div>
        <?php
            function fillDay($day_id, $num)
            {
                $is_something = 0;

                echo "<tr>";
                echo "<td width='4%'>";
                echo $num;
                echo "</td>";
                
                echo "<td>";
                
                //subjects permanent without groups 
                $classData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND tt_chys_znam != 0 AND group_id = 0")[0];
                
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                {
                    //echo "<td>";
                    $isLine = " / <br>";
                    while($class_data=mysqli_fetch_array($classData))
                    {
                        $is_something = 1;
                        list($subject_name) = mysqli_fetch_array(
                                selectData("s_name", "subjects", "WHERE s_id=".$class_data["tt_subject_id"])[0]
                            );
                        list($teacher_name) = mysqli_fetch_array(
                            selectData("t_fullname", "teachers", "WHERE t_id=".$class_data["tt_id_teach"])[0]
                            ); 
                                                
                        echo $subject_name." <i>(".$teacher_name.")</i> ".$isLine;
                        $isLine = "";
                    }
                    //echo "</td>";
                }

                //cabinets permanent without groups
                $classData1 = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                        AND tt_num_lesson=$num AND tt_chys_znam != 0 AND group_id = 0")[0];
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                {
                    $isLine = " / <br>";
                    echo "<td>";
                    while($class_cab=mysqli_fetch_array($classData1))
                    {
                        $is_something = 1;
                        list($cab_num) = mysqli_fetch_array(
                            selectData("cab_num", "cabinets", "WHERE cab_id=".$class_cab["tt_cabinet_id"])[0]
                        );
                        
                        echo $cab_num.$isLine;
                        $isLine = "";
                    }
                    echo "</td>";
                }

                //subjects chys/znam
                $classData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND tt_chys_znam = 0 AND group_id = 0")[0];
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                {
                    //echo "<td>";
                    while($class_data=mysqli_fetch_array($classData))
                    {
                        $is_something = 1;
                        list($subject_name) = mysqli_fetch_array(
                                selectData("s_name", "subjects", "WHERE s_id=".$class_data["tt_subject_id"])[0]
                            );
                        list($cab_num) = mysqli_fetch_array(
                            selectData("cab_num", "cabinets", "WHERE cab_id=".$class_data["tt_cabinet_id"])[0]
                        );
                        list($teacher_name) = mysqli_fetch_array(
                            selectData("t_fullname", "teachers", "WHERE t_id=".$class_data["tt_id_teach"])[0]
                        ); 

                        echo $subject_name." <i>(".$teacher_name.")</i>";
                    
                        if($cab_num != "")
                        {
                            echo "<td width='5%'>";
                            echo $cab_num;
                            echo "</td>";
                        }
                    }
                    //echo "</td>";
                }

                //groups
                $groupClassData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND tt_chys_znam = 0 AND group_id != 0")[0];
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                {
                    $is_something = 1;
                    //echo "<td>";
                    while($group_data=mysqli_fetch_array($groupClassData))
                    {
                        list($subject_name) = mysqli_fetch_array(
                                selectData("s_name", "subjects", "WHERE s_id=".$group_data["tt_subject_id"])[0]
                            );
                        list($teacher_name) = mysqli_fetch_array(
                            selectData("t_fullname", "teachers", "WHERE t_id=".$group_data["tt_id_teach"])[0]
                            ); 
                        
                        echo $subject_name." <i>(".$teacher_name.")</i> "."<br>";
                    }
                    //echo "</td>";
                } 

                $cabinetGroupClassData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND group_id != 0")[0];
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                {
                    $is_something = 1;
                    echo "<td width='5%'>";
                    while($group_data1=mysqli_fetch_array($cabinetGroupClassData))
                    {
                        list($group_cab_num) = mysqli_fetch_array(
                            selectData("cab_num", "cabinets", "WHERE cab_id=".$group_data1["tt_cabinet_id"])[0]
                        );
                        
                        echo $group_cab_num."<br>";
                        //echo selectData("cab_num", "cabinets", "WHERE cab_id=".$group_data["tt_cabinet_id"])[1];
                    }
                    echo "</td>";
                }

                echo "</td>";

                if($is_something == 0)
                    echo "<td width='5%'></td>";

                echo "</tr>";
            }

            $days = ["Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця"];
            if(isset($_GET["classId"]))
            {
                echo "<div style='display: flex; justify-content: center;'>";
                echo "<div>";
                for($day_id=0; $day_id < count($days); $day_id++)
                {
                    echo "<h4>".$days[$day_id]."</h4>";
                    echo "<table border='1' width='450px'>";
                    for($num=1; $num <= 8; $num++)
                    {
                        fillDay($day_id, $num);
                    }
                    echo "</table>";
                }
                echo "</div>";
                echo "</div>";
            }   
        }
        ?>
</body>
</html>