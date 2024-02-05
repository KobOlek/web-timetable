<form method='post' action="">
    <?php
        include("functions.php");

        if(isset($_POST["save_button"])){
            $k_1=0;
            deleteData("timetable", "WHERE tt_class_id = ".$_GET["cl"]." AND tt_day_id = ".$_GET["day"]);
            for($num=1; $num < 9; $num++){
                if(isset($_POST["chyselnyk_".$num])){
                    //echo $_POST["chyselnyk_".$num];
                    $k_1=1;
                }
                if(isset($_POST["znamennyk_".$num])){
                    //echo $_POST["znamennyk_".$num];
                    //$k=1;
                }
                if(isset($_POST["permanent_".$num]) && $k_1 != 0){
                   // echo $_POST["permanent_".$num];
                   if($_POST["permanent_".$num] != "-"){
                        //echo $_POST["subject_chyselnyk_".$num."_1"];
                        insertData("timetable", 
                        "tt_day_id, tt_num_lesson, tt_chys_znam, 
                        tt_permanent, tt_subject_id, tt_class_id",
                        $_GET["day"].", $num, 
                        0, 1, ".$_POST["subject_chyselnyk_".$num."_1"].", ".$_GET["cl"]);
                    }

                }
                if(isset($_POST["subject_chyselnyk_".$num."_1"]) && isset($_POST["chyselnyk_".$num])){
                    if($_POST["subject_chyselnyk_".$num."_1"] != "-"){
                        //echo $_POST["subject_chyselnyk_".$num."_1"];
                        insertData("timetable", 
                        "tt_day_id, tt_num_lesson, tt_chys_znam, 
                        tt_permanent, tt_subject_id, tt_class_id",
                        $_GET["day"].", $num, 
                        1, 0, ".$_POST["subject_chyselnyk_".$num."_1"].", ".$_GET["cl"]);
                    }
                }
                if(isset($_POST["subject_znamennyk_".$num."_2"]) && isset($_POST["znamennyk_".$num])){
                    if($_POST["subject_znamennyk_".$num."_2"] != "-"){
                        //echo $_POST["subject_znamennyk_".$num."_2"];
                        insertData("timetable", 
                        "tt_day_id, tt_num_lesson, tt_chys_znam, 
                        tt_permanent, tt_subject_id, tt_class_id",
                        $_GET["day"].", $num, 
                        2, 0, ".$_POST["subject_znamennyk_".$num."_2"].", ".$_GET["cl"]);
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

                    //echo "Lesson number: ".$num_lesson.", Chys/znam: ".$tt_znam.", Permanent: ".$permanent.", Subject id: ".$subject_id_znam."<br>";
                    
                    echo "<tr><td >".$num."</td>";
                    ?>
                    <script>
                        //document.addEventListener("DOMContentLoaded", function(){});
                    </script>
                    
                    <?php
                    echo "<td>
                    <input type='checkbox' id='chyselnyk_$num' name='chyselnyk_$num' value='".$num."_1' $isCheckedChys>
                    <br>
                    <input type='checkbox' id='znamennyk_$num' name='znamennyk_$num' value='".$num."_2' $isCheckedZnam></td>";
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
                    onclick="setChysZnam(
                        document.getElementById('<?php echo "chyselnyk_$num"; ?>'),
                        document.getElementById('<?php echo "subject_chyselnyk_".$num."_1"; ?>'));"
                    <?php 
                        echo "id='subject_chyselnyk_".$num."_1' name='subject_chyselnyk_".$num."_1'>
                        <option value='-'>Не обрано</option>";
                    $subjects = selectData(
                        "sc.s_id, s.s_name, sc.sc_hours_count", "subjectsandclasses sc, subjects s", "WHERE sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
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
                            document.getElementById('<?php echo "subject_znamennyk_".$num."_2"; ?>'));"
                    <?php

                        echo "id='subject_znamennyk_".$num."_2' name='subject_znamennyk_".$num."_2'> 
                        <option value='-'>Не обрано</option>";
                    $subjects = selectData(
                        "sc.s_id, s.s_name, sc.sc_hours_count", "subjectsandclasses sc, subjects s", "WHERE sc.s_id = s.s_id AND sc.c_id = ".$_GET["cl"]
                        )[0];
                    while($sub = mysqli_fetch_array($subjects)){
                        if($subject_id_znam == $sub["s_id"]) 
                            $isSelected = "selected";
                        else
                            $isSelected = "";
                        echo "<option value='".$sub["s_id"]."' $isSelected>".$sub["s_name"]."(".$sub["sc_hours_count"].")</option>";
                    }
                    echo "</select></td>";
                    echo "</tr>";
                }
            
                echo "</table>";  
            }
        }
    ?>
</form>