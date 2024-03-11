<?php
    for($num=1; $num <= 3; $num++)
    { 
        if(isset($_POST["group_subject_".$num]) && isset($_POST["group_cabinets_".$num]))
        {
            if($_POST["group_subject_$num"] != "-" && $_POST["group_cabinets_$num"] != 0)
            {
                //echo $_POST["subject_chyselnyk_".$num."_1"];
                list($teacher_id) = mysqli_fetch_array(
                    selectData("t_id", "teachersandsubjects", 
                    "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["group_subject_".$num])[0]
                );
                //-----------------------------------------------------------------------------------------------------------------
                //choosing hours of subject
                list($subject_hours) =  mysqli_fetch_array(
                    selectData(
                        "sc_hours_count", "subjectsandclasses", 
                        "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["group_subject_".$num]
                    )[0]
                );
                list($inserted_subject_hours) = mysqli_fetch_array(
                    selectData(
                        "COUNT(*)", "timetable",
                        "WHERE tt_class_id = ".$_GET["cl"]." AND tt_subject_id = ".$_POST["group_subject_".$num]." AND group_id = ".$_GET["group"]
                    )[0]
                );

                echo $inserted_subject_hours."<br>";
                //-----------------------------------------------------------------------------------------------------------------
                
                list($check_class_id, $check_lesson_number, $check_chys_znam, $check_permanent) = mysqli_fetch_array(
                    selectData(
                        "tt_class_id, tt_num_lesson, tt_chys_znam, tt_permanent", "timetable",
                        "WHERE tt_num_lesson = $num AND tt_chys_znam = 0 AND tt_permanent = 1 AND tt_id_teach = $teacher_id"
                    )[0]                         
                );
                    
                if(mysqli_affected_rows($GLOBALS["link"]) == 0){
                    //echo $subject_hours."/".$inserted_subject_hours." ";
                    if($inserted_subject_hours < $subject_hours){
                        
                        // insertData("timetable", 
                        //     "tt_day_id, tt_num_lesson, tt_chys_znam, 
                        //     tt_permanent, tt_subject_id, tt_class_id, tt_id_teach, tt_cabinet_id",
                        //     $_GET["day"].", $num, 
                        //     1, 0, ".$_POST["subject_chyselnyk_".$num."_1"].", ".$_GET["cl"].", 
                        //     ".$teacher_id.", ".$_POST["chys_cabinets_".$num]);

                    }else{
                        //echo "Не знущайтесь над $check_class_id класом! Вони вже мають достатньо цей урок";
                    }
                }else{
                    //echo "Не знущайтесь над людиною! Вона вже має $check_lesson_number урок у <b>$check_class_id</b>";
                }
            }
        }
    }
    

    if(isset($_POST["save_group_button"]))
    {
        deleteData("timetable", 
        "WHERE tt_num_lesson = ".$_GET["group"]." AND tt_day_id = ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]);
        for($num=1; $num <= 3; $num++){
            if($_POST["group_subject_$num"] != "-" && $_POST["group_cabinets_$num"] != 0){
                list($teacher_id) = mysqli_fetch_array(
                    selectData("t_id", "teachersandsubjects", 
                    "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["group_subject_$num"])[0]
                );

                $is_cabinet_free = true;

                for($cabinet_index=1; $cabinet_index <= 3; $cabinet_index++)
                {
                    if($_POST["group_cabinets_$cabinet_index"] != 0 && $num != $cabinet_index)
                    {
                        $is_cabinet_free = $_POST["group_cabinets_$num"] != $_POST["group_cabinets_$cabinet_index"];
                    }
                }

                $current_cabinet_data = 
                    selectData("tt_num_lesson, tt_day_id, tt_class_id", "timetable", 
                    "WHERE tt_num_lesson = ".$_GET["group"]." 
                    AND tt_cabinet_id = ".$_POST["group_cabinets_$num"])[0];

                if($is_cabinet_free && mysqli_affected_rows($GLOBALS["link"]) == 0)
                {
                    echo insertData("timetable", 
                        "tt_day_id, tt_num_lesson, tt_chys_znam, 
                        tt_permanent, tt_subject_id, tt_class_id, 
                        tt_id_teach, tt_cabinet_id, group_id, group_number", 
                        $_GET["day"].", ".$_GET["group"].", 0, 1, ".$_POST["group_subject_$num"].", 
                        ".$_GET["cl"].", $teacher_id, ".$_POST["group_cabinets_$num"].", ".$_GET["group"].", $num");
                }
                else
                {
                    while($data = mysqli_fetch_array($current_cabinet_data))
                    {
                        list($class) = mysqli_fetch_array(
                            selectData("c_name", "classes", "WHERE c_id = ".$data["tt_class_id"])[0]
                        );
                        echo "Цей кабінет вже зайнятий у ".$class." класі !!!";
                    }
                }
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
                <th>Однаковий предмет</th>
            </tr>
            <tr>
                <td>Уроки</td>
                <?php
                    for($num=1; $num <= 3; $num++)
                    {
                        echo "<td><select id='group_subject_$num' name='group_subject_$num'>
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
                <td rowspan="3">
                    <?php

                    echo '<input id="setSameSubjectCheckBox" type="checkbox" onclick="setSameSubject([';
                    for($num=1; $num <= 3; $num++){
                        if($num < 3)
                            $comma = ",";
                        else 
                            $comma = "";
                        echo "document.getElementById('group_subject_$num')".$comma;
                    }
                    echo "], document.getElementById('universal_subject_select'))".'"'.";";
                    echo ">";
                    ?>
                    <br>
                    <select name="universal_subject_select" id="universal_subject_select">
                        <?php
                            echo "<option value='-'>Не обрано</option>";
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
                                echo "<option value='".$sub["s_id"]."'>".$sub["s_name"]."(".$sub["sc_hours_count"].")</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Кабінети</td>
                <?php
                    for($num=1; $num <= 3; $num++){
                        echo "<td>";
                        echo "<select name='group_cabinets_".$num."'>";

                        list($group_cabinet) = mysqli_fetch_array(
                                selectData("tt_cabinet_id", "timetable", 
                                "WHERE tt_day_id = 
                                ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]." AND group_id = ".$_GET["group"]." AND group_number = $num")[0]
                            );

                        if ($group_cabinet=="")
                            echo "<option value='0' selected>-</option>";
                        else
                        {
                            list($cabinetNumber) = mysqli_fetch_array(
                                selectData("cab_num", "cabinets", "WHERE cab_id = ".$group_cabinet)[0]); 
                            echo "<option value=".$group_cabinet." selected>".$cabinetNumber."</option>";
                        }

                        $cabinets = selectData("cab_id, cab_num", "cabinets", 
                        "WHERE cab_id NOT IN(SELECT DISTINCT tt_cabinet_id FROM timetable WHERE tt_num_lesson = $num)")[0];
                        //$cabinets = selectData("cab_id, cab_num", "cabinets")[0];
                        while($cabinetsArray = mysqli_fetch_array($cabinets))
                        {
                            echo "<option value=".$cabinetsArray["cab_id"].">".$cabinetsArray["cab_num"]."</option>";
                        }

                        echo "</select>";
                        echo "</td>";
                    }   
                ?>
            </tr>
            <tr>
                <td>Вчителі</td>
                    <?php
                        for($num=1; $num <= 3; $num++){
                            echo "<td>";
                            echo "<select name='group_cabinets_".$num."'>";

                            echo "<option value='0' selected>-</option>";
                            
                            // list($cabinetNumber) = mysqli_fetch_array(
                            //     selectData("cab_num", "cabinets", "WHERE cab_id = ".$tt_cabinet_id_chys)[0]); 
                            // echo "<option value=".$tt_cabinet_id_chys." selected>".$cabinetNumber."</option>";
                        
                                
                            list($group_teacher) = mysqli_fetch_array(
                                    selectData("tt_id_teach", "timetable", 
                                    "WHERE tt_day_id = 
                                    ".$_GET["day"]." AND tt_class_id = ".$_GET["cl"]." AND group_id = ".$_GET["group"]." AND group_number = $num")[0]
                                );

                            if ($group_teacher=="")
                                echo "<option value='0' selected>-</option>";
                            else
                            {
                                list($teacher_fullname) = mysqli_fetch_array(
                                    selectData("t_fullname", "teachers", "WHERE t_id = ".$group_teacher)[0]); 
                                echo "<option value=".$group_teacher." selected>".$teacher_fullname."</option>";
                            }

                            // $cabinets = selectData("cab_id, cab_num", "cabinets", 
                            // "WHERE cab_id NOT IN(SELECT DISTINCT tt_cabinet_id FROM timetable WHERE tt_num_lesson = $num)")[0];
                            $teachers = selectData("t_id, t_fullname", "teachers", 
                            "WHERE t_id NOT IN(SELECT DISTINCT tt_id_teach FROM timetable WHERE tt_num_lesson = ".$_GET["group"]." 
                            AND tt_day_id = ".$_GET["day"].")")[0];
                            while($teachersArray = mysqli_fetch_array($teachers))
                            {
                                if($group_teacher == $teachersArray["t_id"]) 
                                    $isSelected = "selected";
                                else
                                    $isSelected = "";
                                echo "<option value=".$teachersArray["t_id"]." $isSelected>".$teachersArray["t_fullname"]."</option>";
                            }

                            echo "</select>";
                            echo "</td>";
                        }  
                    ?>
            </tr>
            <tr>
                <td colspan='5'>
                    <input type="submit" name="save_group_button" value="Зберегти зміни">
                </td>
            </tr>
        </table>
    </form>
</p>