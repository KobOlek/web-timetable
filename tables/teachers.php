<?php
    if(isset($_POST["submit_button"])){
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            $work_hours = $_POST["work_hours"];
            if($name != " " && $contact != " " && $work_hours >= 0){
                insertData("teachers", "t_fullname, t_email", "'$name', '$contact', $work_hours");
            }
        }
    }

    if(isset($_POST["edit_button"])){
        if(isset($_POST["fullname_input"]) && isset($_POST["contact_input"])){
            $name_ = $_POST["fullname_input"];
            $contact = $_POST["contact_input"];
            $work_hours = $_POST["work_hours"];
            
            if($name_ != " " && $contact != " " && $work_hours >= 0){
                $name = $name_;
                $email = $contact;
                updateData("teachers", ["t_fullname", "t_email", "work_hours"], ["'$name_'", "'$contact'", $work_hours], "WHERE t_id = ".$_GET["edit"]);
            }        
        }
    }
?>

<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            list($name, $email, $work_hours) = mysqli_fetch_array(
                selectData("t_fullname, t_email, work_hours", "teachers", "WHERE t_id =".$_GET["edit"])[0]
            );
        }
        else
            $name = $email = $work_hours = null;
        
        echo "<input name='fullname_input' type='text' placeholder='Teacher fullname' style='margin: 10px 10px 0 0;' value='$name' >";
        echo "<input name='work_hours' type='number' placeholder='Teacher work hours' style='margin: 10px 10px 0 0;' value='$work_hours'>";
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
    <table  class="table table-striped" border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Fullname</th>
            <th>Hours</th>
            <th>К-сть зайнятих годин</th>
            <th>Contacts</th>
            <th>Change disciplines</th>
        </tr>
        <?php
            while($teachersArray = mysqli_fetch_array($result_array)){
                list($amount_of_occupied_hours) = mysqli_fetch_array(
                    selectData("COUNT(*)", "timetable", 
                    "WHERE tt_id_teach = ".$teachersArray["t_id"])[0]);
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=1&edit=".$teachersArray["t_id"].">edit</a> 
                    </td>
                    <td>".$teachersArray["t_id"]."</td><td>".$teachersArray["t_fullname"]."</td><td>".$teachersArray["work_hours"]."</td>
                    <td>".$amount_of_occupied_hours."</td>
                    <td>".$teachersArray["t_email"]."</td>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=7&t_id=".$teachersArray["t_id"].">Change discipline</a>
                    </td>";
                echo "</tr>";
            }
        ?>
</table>
</div>