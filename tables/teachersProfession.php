<?php
    if(isset($_GET["t_id"])){
        list($class_name) = mysqli_fetch_array(selectData("t_fullname", "teachers", "WHERE t_id = ".$_GET["t_id"])[0]);
        echo $class_name;
    }

    if(isset($_POST["save_button"])){
        deleteData("teachersprofession", "WHERE tp_id_teach = ".$_GET["t_id"]);
        $select_data = selectData("s_id, s_name", "subjects", "ORDER BY s_name");
       
        while($subjectArray = mysqli_fetch_array($select_data[0])){
            if(isset($_POST["profession_".$subjectArray['s_id']])) {
                insertData("teachersprofession", "tp_id_teach, tp_id_subject", $_GET["t_id"].", ".$subjectArray["s_id"]);
            }
        }
    }
?>

<form method="post">
    <?php
        if(isset($_GET["t_id"])){
            echo '<input class="form-button" name="save_button" type="submit" value="Save"><br>';
            echo "<table  class='table table-striped' style='margin: 0 auto;' border='1'>
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