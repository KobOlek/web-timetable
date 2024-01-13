<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            $sql_request = "SELECT s_name, s_comment FROM subjects WHERE s_id =".$_GET["edit"];
            $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
            list($name, $comment) = mysqli_fetch_array($sql_result_array);
        }
        else{
            $name = $comment = null;
        }
        echo "<input name='name_input' type='text' placeholder='Subject name' style='margin: 10px 10px 0 0;' value='$name' >";
        echo '<input name="comment_input" type="text" placeholder="Subject comment" value='.$comment.' >';
        echo "<br />";
        if(isset($_GET["edit"]))
            echo '<input name="edit_button" class="form-button" type="submit" value="Edit" />';
        else
            echo '<input name="submit_button" class="form-button" type="submit" value="Insert" />';
    ?>
</form>

<?php
    $sql_request = "SELECT * FROM subjects";
    $result_array = mysqli_query($GLOBALS['link'], $sql_request);
?>
<div>
    <table border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Name</th>
            <th>Comments</th>
        </tr>
        <?php
            while($subjectsArray = mysqli_fetch_array($result_array)){
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?tb=2&edit=".$subjectsArray["s_id"].">edit</a> 
                    </td>
                    <td>".$subjectsArray["s_id"]."</td><td>".$subjectsArray["s_name"]."</td><td>".$subjectsArray["s_comment"]."</td>";
                echo "</tr>";
            }
        ?>
</table>
</div>
<?php
    function updateData($name, $id){
        $sql_request = "UPDATE subjects SET s_name = '".$name." WHERE s_id = '".$id."'";
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function insertData($name, $comment){
        $table_columns = "
            s_name,
            s_comment
        ";
        $insert_values = "'".$name."', '".$comment."'";
        $sql_insert = "INSERT INTO subjects(".$table_columns.") VALUES (".$insert_values.")";
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
            $comment_ = $_POST["comment_input"];
            
            if($name_ != " " && $comment_ != " "){
                $name = $name_;
                $comment = $comment_;
                updateData($name_, $comment_, $_GET["edit"]);
                
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
            
        }
    }
    if(isset($_POST["submit_button"])){
        if(isset($_POST["name_input"]) && isset($_POST["comment_input"])){
            $name = $_POST["name_input"];
            $comment = $_POST["comment_input"];
            if($name != " " && $comment != " "){
                insertData($name, $comment);
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
        }
    }
?>