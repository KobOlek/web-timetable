<?php
    include("functions.php");

    if(isset($_GET["cl"]))
    {
        list($name) = mysqli_fetch_array(
            selectData("c_name", "classes", "WHERE c_id = ".$_GET['cl'])[0]
        );
        echo "<p>".$name."</p>";

        $d = ["Понедліок", "Вівторок", "Середа", "Четвер", "П'ятниця"];

        for ($j=0; $j < count($d); $j++) { 
            echo "<a href='?tb=".$_GET["tb"]."&cl=".$_GET["cl"]."&day=".($j+1)."'>";
            echo $d[$j]."</a> | ";
        }

        if(isset($_GET["day"])){
            echo "<p>".$d[$_GET["day"]-1]."</p>";  
            echo "<table border='1'>
                <tr>
                    <th>Номер уроку</th>
                    <th><abbr title='Чисельник/знаменник'>Ч/з</abbr></th>
                    <th><abbr title='Постійний урок'>Постійний</abbr></th>
                    <th>Урок</th>
                </tr>";
            
            for($num=1; $num < 9;$num++){
                echo "<tr><td >".$num."</td>";
                echo "<td>
                <input type='checkbox' name='chyselnyk_$num' value='".$num."_1'>
                <br>
                <input type='checkbox' name='znamennyk_$num' value='".$num."_2'></td>";
                echo "<td><input type='checkbox' name='permanent_$num' value='".$num."_0'></td>";
                
                echo "<td><select name='subject_chyselnyk_".$num."_1'>";
                $subjects = selectData(
                    "sc.s_id, s.s_name", "subjectsandclasses sc, subjects s", "WHERE sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                    )[0];
                while($sub = mysqli_fetch_array($subjects)){
                    echo "<option value='".$sub["s_id"]."'>".$sub["s_name"]."</option>";
                }
                echo "</select>";
  
                echo "<br><select name='subject_znamennyk_".$num."_2'>";
                $subjects = selectData(
                    "sc.s_id, s.s_name", "subjectsandclasses sc, subjects s", "WHERE sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                    )[0];
                while($sub = mysqli_fetch_array($subjects)){
                    echo "<option value='".$sub["s_id"]."'>".$sub["s_name"]."</option>";
                }
                echo "</select></td>";
                echo "</tr>";
            }
        
            echo "</table>";  
        }
    }
?>