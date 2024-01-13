<?php
    if(isset($_GET["class"])){
        $sql_request = "SELECT c_name FROM classes WHERE c_id =".$_GET["class"];
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        list($class_name) = mysqli_fetch_array($sql_result_array);
        echo $class_name;
    }
?>

<form method="post">
    <input class="form-button" name="save_button" type="submit" value="Save">
    <br>
    <?php

        $sql_request = "SELECT s_id, s_name FROM subjects ORDER BY s_name";
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        echo "<table style='margin: 0 auto;' border='1'>
            <tr>    
                <th>#</th>
                <th>Назва предмету</th>
                <th>Години</th>
            </tr>
        ";
            while($subjectArray = mysqli_fetch_array($sql_result_array)){
                echo "<tr><td>";
                echo "<input type='checkbox' name='subject_".$subjectArray["s_id"]."' value='".$subjectArray["s_id"]."'>";
                echo "</td>";
                
                echo "<td>";
                echo "<label for='subject_".$subjectArray["s_id"]."'>".$subjectArray["s_name"]."</label><br>";
                echo "</td>";
                
                echo "<td>
                    <input type='number' placeholder='Години' name='hours_".$subjectArray["s_id"]."'>";
                echo "</td>";
            }
        echo "</table>";
    ?>
</form>

<?php
    function insertData($subject_id, $hours){
        $table_columns = "
            c_id,
            s_id, 
            sc_hours_count
        ";
        $insert_values = "".$_GET["class"].", ".$subject_id.", ".$hours."";
        $sql_insert = "INSERT INTO subjectsandclasses(".$table_columns.") VALUES (".$insert_values.")";
        //echo $sql_insert;
        $result = mysqli_query($GLOBALS['link'], $sql_insert);
    }

    if(isset($_POST["save_button"])){
        $sql_request = "SELECT s_id, s_name FROM subjects ORDER BY s_name";
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        while($subjectArray = mysqli_fetch_array($sql_result_array)){
            if(isset($_POST["subject_".$subjectArray['s_id']]) && isset($_POST["hours_".$subjectArray['s_id']])) {
                if($_POST["hours_".$subjectArray['s_id']] > 0){
                    insertData($subjectArray["s_id"], $_POST["hours_".$subjectArray['s_id']]);
                }
            }
        }
    }
?>