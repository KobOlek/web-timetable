<?php
    if(isset($_POST["submit_button"])){
        if(isset($_POST["name_input"])){
            $name = $_POST["name_input"];
            if($name != " "){
                insertData("classes", "c_name", "'$name'");
            }
        }
    }
?>

<form action="" method="post" class="edit-form">
    <?php
        if(isset($_GET["edit"])){
            list($name) = mysqli_fetch_array(
                selectData("c_name", "classes", "WHERE c_id = ".$_GET['edit'])[0]
            );
        }
        else{
            $name = null;
        }
        echo "<input name='name_input' type='text' placeholder='Subject name' style='margin: 10px 10px 0 0;' value='$name' >";
        echo "<br />";
        if(isset($_GET["edit"]))
            echo '<input name="edit_button" class="form-button" type="submit" value="Edit" />';
        else
            echo '<input name="submit_button" class="btn btn-success form-button" type="submit" value="Insert" />';
    ?>
</form>

<?php
    $result_array = selectData("*", "classes")[0];
?>
<div>
    <table border='1'>
        <tr>
            <th>Edit</th>
            <th>Id</th>
            <th>Name</th>
            <th>Subjects</th>
            <th>Teachers</th>
            <th>Timetable</th>
        </tr>
        <?php
            while($subjectsArray = mysqli_fetch_array($result_array)){
                echo "
                <tr>
                    <td>
                        <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=3&edit=".$subjectsArray["c_id"].">edit</a> 
                    </td>
                    <td>".$subjectsArray["c_id"]."</td><td>".$subjectsArray["c_name"]."</td>";
                echo "
                <td>
                    <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=5&class=".$subjectsArray["c_id"].">Змінити предмети</a>
                </td>
                <td>
                    <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=6&class=".$subjectsArray["c_id"].">Перепризначити вчителя</a>
                </td>
                <td>
                    <a href=".$_SERVER["PHP_SELF"]."?menu=admin&tb=8&cl=".$subjectsArray["c_id"].">Сформувати розклад</a>
                </td>
                ";
                echo "</tr>";
            }
        ?>
</table>
</div>
<?php
    if(isset($_POST["edit_button"])){
        if(isset($_POST["name_input"])){
            $name_ = $_POST["name_input"];
            
            if($name_ != " "){
                $name = $name_;
                updateData("classes", ["c_name"], [$name_], "WHERE c_id = ".$_GET["edit"]);
                
                redirectTo("admin.php?tb=".$_GET["tb"]);
            }
            
        }
    }
?>