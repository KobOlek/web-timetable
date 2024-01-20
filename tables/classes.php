<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            $sql_request = "SELECT c_name FROM classes WHERE c_id =".$_GET["edit"];
            $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
            list($name) = mysqli_fetch_array($sql_result_array);
        }
        else{
            $name = null;
        }
        echo "<input name='name_input' type='text' placeholder='Subject name' style='margin: 10px 10px 0 0;' value='$name' >";
        echo "<br />";
        if(isset($_GET["edit"]))
            echo '<input name="edit_button" class="form-button" type="submit" value="Edit" />';
        else
            echo '<input name="submit_button" class="form-button" type="submit" value="Insert" />';
    ?>
</form>

<?php
    $sql_request = "SELECT * FROM classes";
    $result_array = mysqli_query($GLOBALS['link'], $sql_request);
?>
<div>
    <table border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Name</th>
            <th>Subjects</th>
            <th>Teachers</th>
        </tr>
        <?php
            while($subjectsArray = mysqli_fetch_array($result_array)){
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?tb=3&edit=".$subjectsArray["c_id"].">edit</a> 
                    </td>
                    <td>".$subjectsArray["c_id"]."</td><td>".$subjectsArray["c_name"]."</td>";
                echo "
                <td>
                    <a href=".$_SERVER["PHP_SELF"]."?tb=5&class=".$subjectsArray["c_id"].">Змінити предмети</a>
                </td>
                <td>
                    <a href=".$_SERVER["PHP_SELF"]."?tb=6&class=".$subjectsArray["c_id"].">Перепризначити вчителя</a>
                </td>
                ";
                echo "</tr>";
            }
        ?>
</table>
</div>
<?php
    function updateData($name, $id){
        $sql_request = "UPDATE classes SET c_name = '".$name."WHERE c_id = '".$id."'";
        echo $sql_insert;
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function insertData($name){
        $table_columns = "
            c_name
        ";
        $insert_values = "'".$name."'";
        $sql_insert = "INSERT INTO classes(".$table_columns.") VALUES (".$insert_values.")";
        $result = mysqli_query($GLOBALS['link'], $sql_insert);
        
        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function redirectTo($url){
        header("Location: ".$url);
        die();
    }

    if(isset($_POST["edit_button"])){
        if(isset($_POST["name_input"])){
            $name_ = $_POST["name_input"];
            
            if($name_ != " "){
                $name = $name_;
                updateData($name_, $_GET["edit"]);
                
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
            
        }
    }
    if(isset($_POST["submit_button"])){
        if(isset($_POST["name_input"])){
            $name = $_POST["name_input"];
            if($name != " "){
                insertData($name);
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
        }
    }
?>