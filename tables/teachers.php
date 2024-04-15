<?php
    include("functions.php");
    if(isset($_POST["submit_button"])){
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            if($name != " " && $contact != " "){
                insertData("teachers", "t_fullname, t_email", "'".$name."', '".$contact."'");
            }
        }
    }
?>

<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            list($name, $email) = mysqli_fetch_array(
                selectData("t_fullname, t_email", "teachers", "WHERE t_id =".$_GET["edit"])[0]
            );
        }
        else
            $name = $email = null;
        
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
    $result_array = selectData("*", "teachers")[0];
?>
<div>
    <table border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Fullname</th>
            <th>Hours</th>
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
    if(isset($_POST["edit_button"])){
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name_ = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            
            if($name != " " && $contact != " "){
                $name = $name_;
                $email = $contact;
                updateData("teachers", ["t_fullname", "t_email"], [$name_, $contact], "WHERE t_id = ".$_GET["edit"]);
                
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
            
        }
    }
?>