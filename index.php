<?php
    include ('config.php');
    include ("tables/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            $classData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND group_id = 0")[0];
                            $groupClassData = selectData("*", "timetable", "WHERE tt_class_id=".$_GET["classId"]." AND tt_day_id=".($day_id+1)."  
                            AND tt_num_lesson=$num AND group_id != 0")[0];
                            echo "<tr>";
                            echo "<td>";
                            echo $num;
                            echo "</td>";
                            echo "<td>";
                            while($class_data=mysqli_fetch_array($classData))
                            {
                                list($subject_name) = mysqli_fetch_array(
                                        selectData("s_name", "subjects", "WHERE s_id=".$class_data["tt_subject_id"])[0]
                                    );
                            
                                echo $subject_name;
                            }
                            while($group_data=mysqli_fetch_array($groupClassData))
                            {
                                list($subject_name) = mysqli_fetch_array(
                                        selectData("s_name", "subjects", "WHERE s_id=".$group_data["tt_subject_id"])[0]
                                    );
                            
                                echo $subject_name."<br>";
                            }
                            echo "</td>";
                            echo "</tr>";
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
                            echo "<tr>";
                            echo "<td>";
                            echo $num;
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        
                    }
                    echo "</div>";
                    
                }   
            }
        ?>
</body>
</html>