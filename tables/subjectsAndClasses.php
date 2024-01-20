<?php
    if(isset($_GET["class"])){
        list($class_name) = mysqli_fetch_array(selectData("c_name", "classes", "WHERE c_id = ".$_GET["class"])[0]);
        echo $class_name;
    }

    function selectData($column, $table_name, $condition=""){
        $sql_request = "SELECT ".$column." FROM ".$table_name." ".$condition;
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        return [$sql_result_array, $sql_request];
    }
?>

<form method="post">
    <?php
        if(isset($_GET["class"])){
            echo '<input class="form-button" name="save_button" type="submit" value="Save"><br>';
            echo "<table style='margin: 0 auto;' border='1'>
                <tr>    
                    <th>#</th>
                    <th>Назва предмету</th>
                    <th>Години</th>
                </tr>
            ";
            $select_data = selectData("s_id, s_name", "subjects", "ORDER BY s_name");

            while($subjectArray = mysqli_fetch_array($select_data[0])){
                $hours_amount = selectData("sc_hours_count", "subjectsandclasses", 
                "WHERE s_id = ".$subjectArray["s_id"]." AND c_id = ".$_GET["class"]."");
                $is_checked = "";
                if(mysqli_affected_rows($GLOBALS["link"]) > 0){
                    list($hours_amount) = mysqli_fetch_array($hours_amount[0]);
                    $is_checked = " checked";
                }
                else 
                    $hours_amount = "";

                
                echo "<tr><td>";
                echo "<input type='checkbox' name='subject_".$subjectArray["s_id"]."' value='".$subjectArray["s_id"]."'".$is_checked.">";
                echo "</td>";
            
                
                echo "<td>";
                echo "<label for='subject_".$subjectArray["s_id"]."'>".$subjectArray["s_name"]."</label><br>";
                echo "</td>";
            
                echo "<td>
                    <input type='number' placeholder='Години' name='hours_".$subjectArray["s_id"]."' value='".$hours_amount."'>";
                echo "</td>";
            }
            echo "</table>";
        }
    ?>
</form>

<?php
    function redirectTo($url){
        header("Location: ".$url);
        die();
    }

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

    function updateData($subject_id, $class_id, $hours, $id){
        $sql_request = 
        "UPDATE subjectsandclasses SET s_id = ".$subject_id.", c_id = ".$class_id.", sc_hours_count = ".$hours." WHERE sc_id = '".$id."'";
        echo $sql_request;
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function deleteData($table_name, $condition){
        $sql_request = "DELETE FROM ".$table_name." ".$condition;
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    if(isset($_POST["save_button"])){
        deleteData("subjectsandclasses", "WHERE c_id = ".$_GET["class"]);

        $sql_request = "SELECT s_id, s_name FROM subjects ORDER BY s_name";
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
       
        while($subjectArray = mysqli_fetch_array($sql_result_array)){
            if(isset($_POST["subject_".$subjectArray['s_id']]) && isset($_POST["hours_".$subjectArray['s_id']])) {
                if($_POST["hours_".$subjectArray['s_id']] > 0){
                    $data = selectData("sc_id", "subjectsandclasses", "WHERE s_id = ".$subjectArray["s_id"]." AND c_id = ".$_GET["class"]);
                    list($data) = mysqli_fetch_array($data[0]);
                    
                    if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                        updateData($subjectArray["s_id"], $_GET["class"], $_POST["hours_".$subjectArray['s_id']], $data);
                    else
                        insertData($subjectArray["s_id"], $_POST["hours_".$subjectArray['s_id']]);
                }
            }
        }
        redirectTo("admin.php?tb=".$_GET["tb"]."&class=".$_GET["class"]);      
    }
?>