<?php
    if(isset($_GET["t_id"])){
        list($class_name) = mysqli_fetch_array(selectData("t_fullname", "teachers", "WHERE t_id = ".$_GET["t_id"])[0]);
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
        if(isset($_GET["t_id"])){
            echo '<input class="form-button" name="save_button" type="submit" value="Save"><br>';
            echo "<table style='margin: 0 auto;' border='1'>
                <tr>    
                    <th>#</th>
                    <th>Дисципліни</th>
                </tr>
            ";
            $select_data = selectData("s_id, s_name", "subjects", "ORDER BY s_name");

            while($subjectArray = mysqli_fetch_array($select_data[0])){
                $subjects_amount = selectData("tp_id_subject", "teachersprofession", 
                "WHERE tp_id_teach = ".$_GET["t_id"]." AND tp_id_subject = ".$subjectArray["s_id"]);
                $is_checked = "";
                if(mysqli_affected_rows($GLOBALS["link"]) > 0){
                    list($subjects_amount) = mysqli_fetch_array($subjects_amount[0]);
                    $is_checked = " checked";
                }
                else
                    $subjects_amount = "";

                
                echo "<tr><td>";
                echo "<input type='checkbox' name='profession_".$subjectArray["s_id"]."' value='".$subjectArray["s_id"]."'".$is_checked.">";
                echo "</td>";
            
                
                echo "<td>";
                echo "<label for='profession_".$subjectArray["s_id"]."'>".$subjectArray["s_name"]."</label><br>";
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

    function insertData($subject_id){
        $table_columns = "
            tp_id_teach, 
            tp_id_subject
        ";
        $insert_values = "".$_GET["t_id"].", ".$subject_id;
        $sql_insert = "INSERT INTO teachersprofession(".$table_columns.") VALUES (".$insert_values.")";
        //echo $sql_insert;
        $result = mysqli_query($GLOBALS['link'], $sql_insert);
    }

    function updateData($subject_id, $teacher_id, $profession_id){
        $sql_request = 
        "UPDATE teachersprofession SET tp_id_subject = ".$subject_id.", tp_id_teach = ".$teacher_id." WHERE sc_id = '".$profesion_id."'";
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
        deleteData("teachersprofession", "WHERE tp_id_teach = ".$_GET["t_id"]);
        $select_data = selectData("s_id, s_name", "subjects", "ORDER BY s_name");
       
        while($subjectArray = mysqli_fetch_array($select_data[0])){
            if(isset($_POST["profession_".$subjectArray['s_id']])) {
                $data = selectData("tp_id", "teachersprofession", "WHERE tp_id_subject = ".$subjectArray["s_id"]." AND tp_id_teach = ".$_GET["t_id"]);
                list($data) = mysqli_fetch_array($data[0]);
                
                if(mysqli_affected_rows($GLOBALS["link"]) > 0)
                    updateData($subjectArray["s_id"], $_GET["t_id"], $data);
                else
                    insertData($subjectArray["s_id"]);
            
            }
        }
        redirectTo("admin.php?tb=".$_GET["tb"]."&t_id=".$_GET["t_id"]);      
    }
?>