<form method='post' action="">
    <?php
        include("functions.php");

        //-----------------------------------------------------------------------------------------------------------------
        
        function getHours($num, $chys_znam_value, $permanent_value){
            list($teacher_id) = mysqli_fetch_array(
                selectData("t_id", "teachersandsubjects", 
                "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_chyselnyk_".$num."_1"])[0]
            );
            echo $teacher_id."<br>".selectData("t_id", "teachersandsubjects", 
                "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_chyselnyk_".$num."_1"])[1];

            //choosing hours of subject
            list($subject_hours) =  mysqli_fetch_array(
                selectData(
                    "sc_hours_count", "subjectsandclasses", 
                    "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_chyselnyk_".$num."_1"]
                )[0]
            );
            list($inserted_subject_hours) = mysqli_fetch_array(
                selectData(
                    "COUNT(*)", "timetable",
                    "WHERE tt_class_id = ".$_GET["cl"]." AND tt_subject_id = ".$_POST["subject_chyselnyk_".$num."_1"]
                )[0]
            );

            list($check_class_id, $check_lesson_number, $check_chys_znam, $check_permanent) = mysqli_fetch_array(
                selectData(
                    "tt_class_id, tt_num_lesson, tt_chys_znam, tt_permanent", "timetable",
                    "WHERE tt_num_lesson = $num AND tt_chys_znam = 1 AND tt_permanent = 0 AND tt_id_teach = $teacher_id"
                )[0]                         
            );     

            if(mysqli_affected_rows($GLOBALS["link"]) == 0){
                //echo $subject_hours."/".$inserted_subject_hours." ";;
                if($inserted_subject_hours < $subject_hours){
                    insertData("timetable", 
                                    "tt_day_id, tt_num_lesson, tt_chys_znam, 
                                    tt_permanent, tt_subject_id, tt_class_id, tt_id_teach, tt_cabinet_id",
                                    $_GET["day"].", $num, 
                                    0, 1, ".$_POST["subject_chyselnyk_".$num."_1"].", ".$_GET["cl"].", 
                                    ".$teacher_id.", ".$_POST["chys_cabinets_".$num]);

                }else{
                    echo "Не знущайтесь над $check_class_id класом! Вони вже мають достатньо цей урок";
                }
            }else{
                echo "Не знущайтесь над людиною! Вона вже має $check_lesson_number урок у <b>$check_class_id</b>";
            }
        }
        //-----------------------------------------------------------------------------------------------------------------

        if(isset($_POST["save_button"])){
            deleteData("timetable", "WHERE tt_class_id = ".$_GET["cl"]." AND tt_day_id = ".$_GET["day"]);
            for($num=1; $num < 9; $num++){
                // if(isset($_POST["chyselnyk_".$num])){
                //     //echo $_POST["chyselnyk_".$num];
                // }
                // if(isset($_POST["znamennyk_".$num])){
                //     //echo $_POST["znamennyk_".$num];
                //     //$k=1;
                // }
                if(isset($_POST["permanent_".$num])){
                   // echo $_POST["permanent_".$num];
                   if($_POST["permanent_".$num] != "-"){
                        //echo $_POST["subject_chyselnyk_".$num."_1"];
                        getHours($num, 0, 1);
                    }

                }
                if(isset($_POST["subject_chyselnyk_".$num."_1"]) && isset($_POST["chyselnyk_".$num])){
                    if($_POST["subject_chyselnyk_".$num."_1"] != "-"){
                        //echo $_POST["subject_chyselnyk_".$num."_1"];
                        list($teacher_id) = mysqli_fetch_array(
                            selectData("t_id", "teachersandsubjects", 
                            "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_chyselnyk_".$num."_1"])[0]
                        );
                        //-----------------------------------------------------------------------------------------------------------------
                        //choosing hours of subject
                        list($subject_hours) =  mysqli_fetch_array(
                            selectData(
                                "sc_hours_count", "subjectsandclasses", 
                                "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_chyselnyk_".$num."_1"]
                            )[0]
                        );
                        list($inserted_subject_hours) = mysqli_fetch_array(
                            selectData(
                                "COUNT(*)", "timetable",
                                "WHERE tt_class_id = ".$_GET["cl"]." AND tt_subject_id = ".$_POST["subject_chyselnyk_".$num."_1"]
                            )[0]
                        );
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
                               
                                insertData("timetable", 
                                    "tt_day_id, tt_num_lesson, tt_chys_znam, 
                                    tt_permanent, tt_subject_id, tt_class_id, tt_id_teach, tt_cabinet_id",
                                    $_GET["day"].", $num, 
                                    1, 0, ".$_POST["subject_chyselnyk_".$num."_1"].", ".$_GET["cl"].", 
                                    ".$teacher_id.", ".$_POST["chys_cabinets_".$num]);

                            }else{
                                echo "Не знущайтесь над $check_class_id класом! Вони вже мають достатньо цей урок";
                            }
                        }else{
                            echo "Не знущайтесь над людиною! Вона вже має $check_lesson_number урок у <b>$check_class_id</b>";
                        }
                    }
                }
                if(isset($_POST["subject_znamennyk_".$num."_2"]) && isset($_POST["znamennyk_".$num])){
                    if($_POST["subject_znamennyk_".$num."_2"] != "-"){
                        //echo $_POST["subject_znamennyk_".$num."_2"];
                        list($teacher_id) = mysqli_fetch_array(
                            selectData("t_id", "teachersandsubjects", 
                            "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_znamennyk_".$num."_2"])[0]
                        );

                        //-----------------------------------------------------------------------------------------------------------------
                        //choosing hours of subject
                        list($subject_hours) =  mysqli_fetch_array(
                            selectData(
                                "sc_hours_count", "subjectsandclasses", 
                                "WHERE c_id = ".$_GET["cl"]." AND s_id = ".$_POST["subject_znamennyk_".$num."_2"]
                            )[0]
                        );
                        list($inserted_subject_hours) = mysqli_fetch_array(
                            selectData(
                                "COUNT(*)", "timetable",
                                "WHERE tt_class_id = ".$_GET["cl"]." AND tt_subject_id = ".$_POST["subject_znamennyk_".$num."_2"]
                            )[0]
                        );

                        list($check_class_id, $check_lesson_number, $check_chys_znam, $check_permanent) = mysqli_fetch_array(
                            selectData(
                                "tt_class_id, tt_num_lesson, tt_chys_znam, tt_permanent", "timetable",
                                "WHERE tt_num_lesson = $num AND tt_chys_znam = 2 AND tt_permanent = 0 AND tt_id_teach = $teacher_id"
                            )[0]                         
                        );
                        //-----------------------------------------------------------------------------------------------------------------
                        if(mysqli_affected_rows($GLOBALS["link"]) == 0){
                            //echo $subject_hours."/".$inserted_subject_hours." ";
                            if($inserted_subject_hours < $subject_hours){
                                insertData("timetable", 
                                    "tt_day_id, tt_num_lesson, tt_chys_znam, 
                                    tt_permanent, tt_subject_id, tt_class_id, tt_id_teach, tt_cabinet_id",
                                    $_GET["day"].", $num, 
                                    2, 0, ".$_POST["subject_znamennyk_".$num."_2"].", ".$_GET["cl"].", ".$teacher_id.", ".$_POST["znam_cabinets_".$num]);

                            }else{
                                echo "Не знущайтесь над $check_class_id класом! Вони вже мають достатньо цей урок";
                            }
                        }else{
                            echo "Не знущайтесь над людиною! Вона вже має $check_lesson_number урок у <b>$check_class_id</b>";
                        }
                    }
                }
            }
        }

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
                echo "<br><input type='submit' name='save_button'>";
                echo "<table border='1'>
                    <tr>
                        <th>Номер уроку</th>
                        <th><abbr title='Чисельник/знаменник'>Ч/з</abbr></th>
                        <th><abbr title='Постійний урок'>Постійний</abbr></th>
                        <th>Урок</th>
                        <th>Кабінет</th>
                    </tr>";
                // $data = selectData("day_id, tt_chys_znam, sc_id", 
                // "timetable", "WHERE tt_chys_znam = 1 AND sc_id = ".$_GET["cl"]." AND day_id = ".$_GET["day"])[0];
                    
                for($num=1; $num < 9; $num++){   
                    //чисельник
                    $data = selectData("tt_num_lesson, tt_chys_znam, tt_permanent, tt_subject_id", 
                    "timetable", "WHERE tt_chys_znam != 2 AND tt_num_lesson = $num AND 
                    tt_class_id = ".$_GET["cl"]." AND tt_day_id = ".$_GET["day"])[0];
                    list($num_lesson, $tt_chys, $permanent, $subject_id_chys) = 
                    mysqli_fetch_array($data);
                    
                    if($tt_chys == 1){
                        $isCheckedChys = "checked";
                    }else
                        $isCheckedChys = "";
                    
                    //permanent
                    if($permanent == 1 && $tt_chys == 0){
                        $isCheckedPermanent = "checked";

                    }else{
                        $isCheckedPermanent = "";
                    }

                    if($tt_chys == 1 && $permanent == 0){
                        echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            turnOffPermanent(
                        document.getElementById('chyselnyk_$num'),
                        document.getElementById('permanent_$num'), 
                        )
                        });";
                        echo "</script>";
                    }

                    elseif($tt_chys == 0 && $permanent == 1){
                        echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            setPermanent(
                                document.getElementById('permanent_$num'),
                                document.getElementById('znamennyk_$num'),
                                document.getElementById('chyselnyk_$num'),
                                document.getElementById('subject_znamennyk_$num"."_2'),
                                document.getElementById('subject_chyselnyk_$num"."_1'))
                        });";
                        echo "</script>";
                    }

                    //echo "Lesson number: ".$num_lesson.", Chys/znam: ".$tt_chys.", Permanent: ".$permanent.", Subject id: ".$subject_id_chys."<br>";
                    
                    //Знаменник
                    $data = selectData("tt_num_lesson, tt_chys_znam, tt_permanent, tt_subject_id", 
                    "timetable", "WHERE tt_chys_znam = 2 AND tt_num_lesson = $num AND 
                    tt_class_id = ".$_GET["cl"]." AND tt_day_id = ".$_GET["day"])[0];
                    list($num_lesson, $tt_znam, $permanent, $subject_id_znam) = 
                    mysqli_fetch_array($data);
                    
                    if($tt_znam == 2){
                        $isCheckedZnam = "checked";
                        
                    }else
                        $isCheckedZnam = "";

                    if($tt_chys == 1 && $permanent == 0){
                        echo "<script>
                        document.addEventListener('DOMContentLoaded', function(){
                            turnOffPermanent(
                        document.getElementById('chyselnyk_$num'),
                        document.getElementById('permanent_$num'), 
                        )
                        });";
                        echo "</script>";
                    }

                    //echo "Lesson number: ".$num_lesson.", Chys/znam: ".$tt_znam.", Permanent: ".$permanent.", Subject id: ".$subject_id_znam."<br>";
                    
                    echo "<tr><td >".$num."</td>";
                    
                    ?>

                    <script>
                        
                    </script>
                    
                    <?php
                    echo "<td>
                    <input";
                    ?>
                    onchange="turnOffPermanent(
                        document.getElementById('<?php echo "chyselnyk_$num"; ?>'),
                        document.getElementById('<?php echo "permanent_$num"; ?>'), 
                        )"
                    <?php
                        echo "type='checkbox' id='chyselnyk_$num' name='chyselnyk_$num' value='".$num."_1' $isCheckedChys>
                    <br>
                    <input";?>
                    onchange="turnOffPermanent(
                        document.getElementById('<?php echo "znamennyk_$num"; ?>'),
                        document.getElementById('<?php echo "permanent_$num"; ?>'), 
                        )"
                    
                    <?php
                        echo " type='checkbox' id='znamennyk_$num' name='znamennyk_$num' value='".$num."_2' $isCheckedZnam></td>";

                    echo "<td><input";?>
                    onchange="setPermanent(
                        document.getElementById('<?php echo "permanent_$num"; ?>'),
                        document.getElementById('<?php echo "znamennyk_$num"; ?>'),
                        document.getElementById('<?php echo "chyselnyk_$num"; ?>'),
                        document.getElementById('<?php echo "subject_znamennyk_".$num."_2"; ?>'),
                        document.getElementById('<?php echo "subject_chyselnyk_".$num."_1"; ?>'));"
                    
                    <?php
                        echo "type='checkbox' id='permanent_$num' name='permanent_$num' value='".$num."_0' $isCheckedPermanent></td>";
                    
                    echo "<td><select" ; ?>
                    onclick="setSelect(
                        document.getElementById('<?php echo "permanent_$num"; ?>'),
                        document.getElementById('<?php echo "subject_chyselnyk_".$num."_1"; ?>'),
                        [document.getElementById('<?php echo "chyselnyk_$num"; ?>'), 
                        document.getElementById('<?php echo "znamennyk_$num"; ?>'),
                        document.getElementById('<?php echo "subject_znamennyk_".$num."_2"; ?>')]);"
                    <?php 
                        echo "id='subject_chyselnyk_".$num."_1' name='subject_chyselnyk_".$num."_1'>
                        <option value='-'>Не обрано</option>";
                    $subjects = selectData(
                        "DISTINCT sc.s_id, s.s_name, sc.sc_hours_count", 
                        "subjectsandclasses sc, subjects s", 
                        "WHERE sc.s_id IN (SELECT s_id FROM teachersandsubjects WHERE c_id=".$_GET["cl"].") AND sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                        )[0];
                    while($sub = mysqli_fetch_array($subjects)){
                        if($subject_id_chys == $sub["s_id"]) 
                            $isSelected = "selected";
                        else
                            $isSelected = "";
                        echo "<option value='".$sub["s_id"]."' $isSelected>".$sub["s_name"]."(".$sub["sc_hours_count"].")</option>";
                    }
                    echo "</select>";
                    echo "<br><select"; ?>
                        onclick="setChysZnam(
                            document.getElementById('<?php echo "znamennyk_$num"; ?>'),
                            document.getElementById('<?php echo "subject_znamennyk_".$num."_2"; ?>'),
                            document.getElementById('<?php echo "permanent_$num"; ?>'));"
                    <?php

                        echo "id='subject_znamennyk_".$num."_2' name='subject_znamennyk_".$num."_2'> 
                        <option value='-'>Не обрано</option>";
                    $subjects = selectData(
                        "DISTINCT sc.s_id, s.s_name, sc.sc_hours_count", 
                        "subjectsandclasses sc, subjects s", 
                        "WHERE sc.s_id IN (SELECT s_id FROM teachersandsubjects WHERE c_id=".$_GET["cl"].") AND sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                        )[0];
                    while($sub = mysqli_fetch_array($subjects)){
                        if($subject_id_znam == $sub["s_id"]) 
                            $isSelected = "selected";
                        else
                            $isSelected = "";
                        echo "<option value='".$sub["s_id"]."' $isSelected>".$sub["s_name"]."(".$sub["sc_hours_count"].")</option>";
                    }
                    echo "</select></td>";

                    //------------------------------------------------------------------------------
                    echo "<td>";
                    echo "<select name='chys_cabinets_".$num."'>";
                    echo "<option value='0'>Не обрано</option>";

                    $cabinets = selectData("cab_id", "cabinets")[0];
                    while($cabinetsArray = mysqli_fetch_array($cabinets)){
                        list($cabinetNumber) = mysqli_fetch_array(
                            selectData("cab_num", "cabinets", "WHERE cab_id = ".$cabinetsArray["cab_id"])[0]
                        ); 
                
                        list($cabinetId) = mysqli_fetch_array(
                            selectData("tt_cabinet_id", "timetable", 
                            "WHERE tt_num_lesson = $num AND tt_class_id = ".$_GET["cl"]." AND tt_chys_znam = 1")[0]
                        );
                        $is_selected = ($cabinetId == $cabinetsArray['cab_id']) ? ' selected' : '';
                        echo "<option value=".$cabinetsArray["cab_id"].$is_selected.">".$cabinetNumber."</option>";
                    }

                    echo "</select><br>";
                    
                    //-------------------------------------------------------------------------------------------
                    echo "<select name='znam_cabinets_".$num."'>";
                    //--------вивід обраного кабвнету
                    $cab_id=0;
                    list($cab_id, $cab_num) = mysqli_fetch_array(
                            selectData("с.cab_id, с.cab_num", "cabinets с, timetable е", "WHERE tt_cabinet_id=cab_id and tt_num_lesson = $num AND tt_class_id = ".$_GET["cl"]." AND tt_chys_znam = 2")[0]
                        ); 
                     //--------вивід обраного кабвнету
                     if ($cab_id==0)
                        echo "<option value='0' selected>-</option>";
                    else
                        echo "<option value=".$cab_id." selected>".$cab_num."</option>";
                    $cabinets = selectData("cab_id", "cabinets", 
                    "WHERE cab_id NOT IN(SELECT DISTINCT tt_cabinet_id FROM timetable WHERE tt_num_lesson = $num AND tt_chys_znam = 2)")[0];
                    while($cabinetsArray = mysqli_fetch_array($cabinets)){
                        list($cabinetNumber) = mysqli_fetch_array(
                            selectData("cab_num", "cabinets", "WHERE cab_id = ".$cabinetsArray["cab_id"])[0]
                        ); 
                
                        list($cabinetId) = mysqli_fetch_array(
                            selectData("tt_cabinet_id", "timetable", 
                            "WHERE tt_num_lesson = $num AND tt_class_id = ".$_GET["cl"]." AND tt_chys_znam = 2")[0]
                        );
                        $is_selected = ($cabinetId == $cabinetsArray['cab_id']) ? ' selected' : '';
                        echo "<option value=".$cabinetsArray["cab_id"].$is_selected.">".$cabinetNumber."</option>";
                    }

                    echo "</select>";
                    //-------------------------------------------------------------------------------------------
                    
                    echo "</td>";
                    //------------------------------------------------------------------------------
                    echo "</tr>";
                }
            
                echo "</table>";  
            }
        }
    ?>
</form>