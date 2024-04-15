<?php
    include ('config.php');
    include ("tables/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>
    <?php
        $first_class_number = 5;
        $last_class_number = 12;
    ?>
    <div>
        <table align="center" width="900px" border='1'>
            <caption><h3>Оберіть номер класу</h3></caption>
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
            <div>
                <table align="center" width="900px" border='1'>
                    <caption><h3>Знайдено такі класи</h3></caption>
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
                echo "<td>";
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
                            echo "<td>";
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
                    echo "<td>";
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
                    echo "<td></td>";

                echo "</tr>";
            }

            $days = ["Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця"];
            if(isset($_GET["classId"]))
            {
                echo "<div width=100% style='display: flex; align-items: space-evenly; flex-direction: column;'>";
                echo "<div width=100% style='display: flex; justify-content: space-around;'>";
                for($day_id=0; $day_id < count($days)-2; $day_id++)
                {
                    echo "<table border='1' width=100%>  
                    <caption>".$days[$day_id]."</caption>";
                    for($num=1; $num <= 8; $num++)
                    {
                        fillDay($day_id, $num);
                    }
                    echo "</table>";
                }
                echo "</div>";
                echo "<div style='display: flex;'>";
                for($day_id=count($days)-2; $day_id < count($days); $day_id++)
                {
                    echo "<table border='1' width=100%>  
                    <caption>".$days[$day_id]."</caption>";
                    for($num=1; $num <= 8; $num++)
                    {
                        fillDay($day_id, $num);
                    }
                    echo "</table>";
                    
                }
                echo "</div>";
            }   
        }
        ?>
</body>
</html>