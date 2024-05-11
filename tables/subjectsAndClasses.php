<?php
    if(isset($_GET["class"])){
        list($class_name) = mysqli_fetch_array(selectData("c_name", "classes", "WHERE c_id = ".$_GET["class"])[0]);
        echo $class_name;
    }
    
    if(isset($_POST["save_button"])){
        deleteData("subjectsandclasses", "WHERE c_id = ".$_GET["class"]);

        $sql_request = "SELECT s_id, s_name FROM subjects ORDER BY s_name";
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
       
        while($subjectArray = mysqli_fetch_array($sql_result_array)){
            if(isset($_POST["subject_".$subjectArray['s_id']]) && isset($_POST["hours_".$subjectArray['s_id']])) {
                if($_POST["hours_".$subjectArray['s_id']] > 0){
                    insertData("subjectsandclasses",
                    "c_id, s_id, sc_hours_count", $_GET["class"].", ".$subjectArray["s_id"].", ".$_POST["hours_".$subjectArray['s_id']]);
                }
            }
        }   
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
