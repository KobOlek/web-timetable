<form method="post">
    <?php
        include("functions.php");

        if(isset($_GET["class"])){
            $sql_request = "SELECT c_name FROM classes WHERE c_id = ".$_GET["class"];
            $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
            list($name) = mysqli_fetch_array($sql_result_array);
            echo "<p>".$name."</p>";
        
            echo '<input class="form-button" name="save_button" type="submit" value="Save"><br>';
            echo "<table style='margin: 0 auto;' border='1'>
                <tr>    
                    <th>Дисципліни</th>
                    <th>Вчителі</th>
                </tr>
            ";
            $select_data = selectData("s_id", "subjectsandclasses", "WHERE c_id = ".$_GET["class"]);

            while($subjectsAndClassestArray = mysqli_fetch_array($select_data[0])){
                $subjects_amount = selectData("t_id", "teachersandsubjects", 
                "WHERE c_id = ".$_GET["class"]." AND s_id = ".$subjectsAndClassestArray["s_id"]);
                $is_selected = "";

                if(mysqli_affected_rows($GLOBALS["link"]) > 0){
                    list($subjects_amount) = mysqli_fetch_array($subjects_amount[0]);
                    $is_selected = " selected";
                }
                else
                    $subjects_amount = "";

                
                echo "<tr>";
                //echo"<td>";
                // echo "<input type='checkbox' name='profession_".$subjectsAndClassestArray["s_id"]."' 
                // value='".$subjectsAndClassestArray["s_id"]."'".$is_checked.">";
                // echo "</td>";
            
                $subjectsArray = selectData("s_name", "subjects", "WHERE s_id = ".$subjectsAndClassestArray["s_id"]." ORDER BY s_name");
                $subjectsArray = mysqli_fetch_array($subjectsArray[0]);
                echo "<td>";
                echo "<label for='profession_".$subjectsAndClassestArray["s_id"]."'>".$subjectsArray["s_name"]."</label><br>";
                echo "</td>";
                
                echo "<td>";
                echo "<select name='teachers_select'>";
                
                $teachersArray = selectData("tp_id_teach", "teachersprofession", "WHERE tp_id_subject = ".$subjectsAndClassestArray["s_id"])[0];
                while($teachersProfessionsArray = mysqli_fetch_array($teachersArray)){
                    list($teacherName) = mysqli_fetch_array(
                        selectData("t_fullname", "teachers", "WHERE t_id = ".$teachersProfessionsArray["tp_id_teach"])[0]
                    );
                    echo "<option value=".$teachersProfessionsArray["tp_id_teach"]." ".$is_selected.">".$teacherName."</option>";
                }

                echo "</select>";
                echo "</td>";
            }
        }
    ?>
</form>

<?php
    if(isset($_POST["save_button"])){
        deleteData("teachersandsubjects", "WHERE c_id = ".$_GET["class"]);

        $sql_request = "SELECT s_id, s_name FROM subjects ORDER BY s_name";
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
       
        while($subjectArray = mysqli_fetch_array($sql_result_array)){
            if(isset($_POST["profession_".$subjectArray['s_id']]) && isset($_POST["teachers_select"])) {
                insertData("teachersandsubjects", "t_id, s_id, c_id", 
                $_POST["teachers_select"].", ".$subjectArray["s_id"].", ".$_GET["class"]);
            }
        }
        redirectTo("admin.php?tb=".$_GET["tb"]."&class=".$_GET["class"]);      
    }
?>