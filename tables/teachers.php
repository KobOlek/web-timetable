<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            $sql_request = "SELECT t_fullname, t_email FROM teachers WHERE t_id =".$_GET["edit"];
            $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
            list($name, $email) = mysqli_fetch_array($sql_result_array);
        }
        else{
            $name = $email = null;
        }
        echo "<input name='fullname_input' type='text' placeholder='Teacher fullname' style='margin: 10px 10px 0 0;' value='$name' >";
        echo '<input name="contact_input" type="text" placeholder="Teacher contacts" value='.$email.' >';
        echo "<br />";
        if(isset($_GET["edit"]))
            echo '<input name="edit_button" class="form-button" type="submit" value="Edit" />';
        else
            echo '<input name="submit_button" class="form-button" type="submit" value="Insert" />';
    ?>
</form>

<?php
    $sql_request = "SELECT * FROM teachers";
    $result_array = mysqli_query($GLOBALS['link'], $sql_request);
?>
<div>
    <table border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Fullname</th>
            <th>Contacts</th>
            <th>Change disciplines</th>
        </tr>
        <?php
            while($teachersArray = mysqli_fetch_array($result_array)){
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?tb=1&edit=".$teachersArray["t_id"].">edit</a> 
                    </td>
                    <td>".$teachersArray["t_id"]."</td><td>".$teachersArray["t_fullname"]."</td><td>".$teachersArray["t_email"]."</td>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?tb=7&t_id=".$teachersArray["t_id"].">Change discipline</a>
                    </td>";
                echo "</tr>";
            }
        ?>
</table>
</div>
<?php
    function updateData($name, $email, $id){
        $sql_request = "UPDATE teachers SET t_fullname = '".$name."', t_email = '".$email."' WHERE t_id = '".$id."'";
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function insertData($name, $email){
        $table_columns = "
            t_fullname,
            t_email
        ";
        $insert_values = "'".$name."', '".$email."'";
        $sql_insert = "INSERT INTO teachers(".$table_columns.") VALUES (".$insert_values.")";
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
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name_ = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            
            if($name != " " && $contact != " "){
                $name = $name_;
                $email = $contact;
                updateData($name_, $contact, $_GET["edit"]);
                
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
            
        }
    }
    if(isset($_POST["submit_button"])){
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            if($name != " " && $contact != " "){
                insertData($name, $contact);
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
        }
    }
?>