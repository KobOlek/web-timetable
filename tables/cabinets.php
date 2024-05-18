<form action="" method="post" class="edit-form">
    <?php
        if(isset($_POST["edit_button"])){
            if(isset($_POST["name_input"]) && isset($_POST["room_number"])){
                $name_ = $_POST["name_input"];
                $room_num_ = $_POST["room_number"];

                if($name_ != " " && $room_num_ != " "){
                    $name = $name_;
                    $room_num = $room_num_; 
                    updateData("cabinets", ["cab_name", "cab_num"], ["'$name_'", $room_num_],  "WHERE cab_id = ".$_GET["edit"]);
                }
                
            }
        }
        if(isset($_POST["submit_button"])){
            if(isset($_POST["name_input"]) && isset($_POST["room_number"])){
                $name = $_POST["name_input"];
                $room_num = $_POST["room_number"];
                if($name != " " && $room_num != " "){
                    insertData("cabinets", "cab_name, cab_num","'".$name."', '".$room_num."'");
                }
            }
        }

        if(isset($_GET["edit"])){

            list($name, $room_num) = mysqli_fetch_array(
                selectData("cab_name, cab_num", "cabinets", "WHERE cab_id =".$_GET["edit"])[0]
            );
        }
        else
            $name = $room_num = null;
        
        echo "<input name='name_input' type='text' placeholder='Room name' style='margin: 10px 10px 0 0;' value='$name' >";
        echo "<input name='room_number' type='number' placeholder='Room number' style='margin 10px 10px 0 0;' value='$room_num'>";
        echo "<br />";
        if(isset($_GET["edit"]))
            echo '<input name="edit_button" class="form-button" type="submit" value="Edit" />';
        else
            echo '<input name="submit_button" class="form-button" type="submit" value="Insert" />';
    ?>
</form>

<div>
    <table class="table table-striped" border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Name</th>
            <th>Number</th>
        </tr>
        <?php
            $result_array = selectData("*", "cabinets")[0];
            while($cabinetsArray = mysqli_fetch_array($result_array)){
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=4&edit=".$cabinetsArray["cab_id"].">edit</a> 
                    </td>
                    <td>".$cabinetsArray["cab_id"]."</td><td>".$cabinetsArray["cab_name"]."</td>
                    <td>".$cabinetsArray["cab_num"]."</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>