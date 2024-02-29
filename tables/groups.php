<?php
    if(isset($_POST["save_group_button"])){
        deleteData("timetable", 
        "WHERE tt_num_lesson = ".$_GET["group"]." AND tt_day_id = ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]);
        for($num=1; $num <= 3; $num++){
            if($_POST["group_subject_$num"] != "-" && $_POST["group_cabinets_$num"] != 0){
                list($teacher_id) = mysqli_fetch_array(
                    selectData("t_id", "teachersandsubjects", 
                    "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["group_subject_$num"])[0]
                );

                insertData("timetable", 
                    "tt_day_id, tt_num_lesson, tt_chys_znam, 
                    tt_permanent, tt_subject_id, tt_class_id, 
                    tt_id_teach, tt_cabinet_id, group_id, group_number", 
                    $_GET["day"].", ".$_GET["group"].", 0, 1, ".$_POST["group_subject_$num"].", 
                    ".$_GET["cl"].", $teacher_id, ".$_POST["group_cabinets_$num"].", ".$_GET["group"].", $num");
            }else{
                if($_POST["group_subject_$num"] == "-" && $_POST["group_cabinets_$num"] == 0)
                    echo "Нічого не вибрано у групі $num<br>";
                elseif($_POST["group_subject_$num"] == "-")
                    echo "Не вибраний предмет у групі $num<br>";
                elseif($_POST["group_cabinets_$num"] == 0)
                    echo "Не вибраний кабінет у групі $num<br>";
            }
        }
    }
?>

<p>
    <form action="post">
        <table border='1'>
            <tr>
                <th></th>
                <th>Група 1</th>
                <th>Група 2</th>
                <th>Група 3</th>
            </tr>
            <tr>
                <td>Уроки</td>
                <?php
                    for($num=1; $num <= 3; $num++)
                    {
                        echo "<td><select name='group_subject_$num'>
                        <option value='-'>Не обрано</option>";
                        $subjects = selectData(
                            "DISTINCT sc.s_id, s.s_name, sc.sc_hours_count", 
                            "subjectsandclasses sc, subjects s", 
                            "WHERE sc.s_id IN (SELECT s_id FROM teachersandsubjects WHERE c_id = ".$_GET["cl"].") AND sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                            )[0];
                        
                        list($group_subject) = mysqli_fetch_array(
                                selectData("tt_subject_id", "timetable", 
                                "WHERE tt_day_id = 
                                ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]." AND group_id = ".$_GET["group"]." AND group_number = $num")[0]
                            );
                        
                        while($sub = mysqli_fetch_array($subjects))
                        {
                            if($group_subject == $sub["s_id"]) 
                                $isSelected = "selected";
                            else
                                $isSelected = "";
                            echo "<option value='".$sub["s_id"]."' $isSelected>".$sub["s_name"]."(".$sub["sc_hours_count"].")</option>";
                        }
                     
                        echo "</select>";
                    }
                ?>
            </tr>
            <tr>
                <td>Кабінети</td>
                <?php
                    for($num=1; $num <= 3; $num++){
                        echo "<td>";
                        echo "<select name='group_cabinets_".$num."'>";

                        echo "<option value='0' selected>-</option>";
                        
                        // list($cabinetNumber) = mysqli_fetch_array(
                        //     selectData("cab_num", "cabinets", "WHERE cab_id = ".$tt_cabinet_id_chys)[0]); 
                        // echo "<option value=".$tt_cabinet_id_chys." selected>".$cabinetNumber."</option>";
                    
                            
                        list($group_cabinet) = mysqli_fetch_array(
                                selectData("tt_cabinet_id", "timetable", 
                                "WHERE tt_day_id = 
                                ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]." AND group_id = ".$_GET["group"]." AND group_number = $num")[0]
                            );

                        // $cabinets = selectData("cab_id, cab_num", "cabinets", 
                        // "WHERE cab_id NOT IN(SELECT DISTINCT tt_cabinet_id FROM timetable WHERE tt_num_lesson = $num)")[0];
                        $cabinets = selectData("cab_id, cab_num", "cabinets")[0];
                        while($cabinetsArray = mysqli_fetch_array($cabinets))
                        {
                            if($group_cabinet == $cabinetsArray["cab_id"]) 
                                $isSelected = "selected";
                            else
                                $isSelected = "";
                            echo "<option value=".$cabinetsArray["cab_id"]." $isSelected>".$cabinetsArray["cab_num"]."</option>";
                        }

                        echo "</select>";
                        echo "</td>";
                    }   
                ?>
            </tr>
            <tr>
                <td colspan='4'>
                    <input type="submit" name="save_group_button" value="Зберегти зміни">
                </td>
            </tr>
        </table>
    </form>
</p>