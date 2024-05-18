<?php
    $class_hours = selectData("sc.s_id AS sc_s_id, s_name, sc_hours_count", "subjectsandclasses sc, subjects s", "WHERE sc.s_id = s.s_id AND sc.c_id=".$_GET["cl"])[0];
?>
<table  class="table">
    <tr>
    <td valign="top">
        <table  class="table table-striped" border='1'>
            <caption>Години</caption>
            <tr>
                <th>Предмет</th>
                <th>Використано <br> годин</th>
                <th>Заплановано <br> годин</th>
            </tr>
            <?php
                while($hours=mysqli_fetch_array($class_hours))
                {
                    $count_subjects_hours = selectData("COUNT(*)", "timetable", 
                    "WHERE tt_class_id=".$_GET["cl"]." AND tt_subject_id = ".$hours["sc_s_id"]." AND group_id = 0")[0];
                    list($subject_hours)=mysqli_fetch_array($count_subjects_hours);

                    $cell_color = $subject_hours == $hours["sc_hours_count"] ? "#0D2C01" : "white";
                    $text_color = $subject_hours == $hours["sc_hours_count"] ? "#3EB60F" : "black";

                    echo "<tr>";
                    echo "<td style='background: $cell_color; color: $text_color;' >".$hours["s_name"]."</td> 
                    <td style='background: $cell_color; color: $text_color;'>$subject_hours</td>
                    <td style='background: $cell_color; color: $text_color;'>".$hours["sc_hours_count"]."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </td>
    <td style="width: 100px;"></td>
    <td valign="top">
        <table  class="table table-striped" border='1'>
            <caption>Кабінети</caption>
            <tr>
                <td></td>
                <?php
                    function getCabinetColorsAccordingToStatus($cabinet_id, $num)
                    {
                        $timetable_cabinets_data = selectData("tt_day_id, tt_cabinet_id, tt_class_id, tt_num_lesson", "timetable")[0];
                        while($timetable_cabinet_data=mysqli_fetch_array($timetable_cabinets_data))
                        {
                            if(isset($_GET["day"]))
                            {
                                if($timetable_cabinet_data["tt_day_id"] == $_GET["day"] && $timetable_cabinet_data["tt_num_lesson"] == $num)
                                {
                                    if($cabinet_id == $timetable_cabinet_data["tt_cabinet_id"])
                                    {
                                        if($timetable_cabinet_data["tt_class_id"] == $_GET["cl"])
                                        {
                                            return "occupiedInCurrentClass";   
                                        }
                                        else
                                        {
                                            return "occupiedInOtherClass";
                                        }
                                    }
                                }
                            }
                        }
                        return "free";
                    }

                    $cabinets = selectData("cab_id, cab_num", "cabinets")[0];
                    $cell_colors = array(
                        "occupiedInCurrentClass" => "red",
                        "occupiedInOtherClass" => "yellow",
                        "free" => "darkgreen"
                    );
                    for($num=1; $num <= 8; $num++)
                    {
                        echo "<td>$num</td>";
                    }
                    while($cabinet=mysqli_fetch_array($cabinets))
                    {    
                        echo "<tr>";
                        echo "<td>".$cabinet["cab_num"]."</td>";
                        for($n=1; $n <= 8; $n++)
                        {
                            $cell_color = getCabinetColorsAccordingToStatus($cabinet["cab_id"], $n);
                            $cell_text = "";
                            switch($cell_colors[$cell_color])
                            {
                                case "red":
                                    $cell_text = "Зайнятий";
                                    break;
                                case "yellow":
                                    $cell_text = "Зайнятий в іншому класі";
                                    break;
                                case "darkgreen":
                                    $cell_text = "Вільний";
                                    break;
                            }

                            echo "
                            <td style='background: ".$cell_colors[$cell_color]."; color: ".$cell_colors[$cell_color].";'>
                            <abbr title='$cell_text'>l</abbr>
                            </td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </tr>
        </table>
    </td>
    </tr>
</table>