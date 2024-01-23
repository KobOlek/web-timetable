<?php
    include("functions.php");
?>

<?php
    if(isset($_GET["cl"]))
    {
        list($name) = mysqli_fetch_array(
            selectData("c_name", "classes", "WHERE c_id = ".$_GET['cl'])[0]
        );
        echo "<p>".$name."</p>";

        $d = ["Понедліок", "Вівторок", "Середа", "Четвер", "П'ятниця"];

        for ($j=0; $j < 5 ; $j++) { 
            echo "<a href='?tb=".$_GET["tb"]."&cl=".$_GET["cl"]."&day=".($j+1)."'>";
            echo $d[$j]."</a> | ";
        }

        if(isset($_GET["day"]))
            echo "<p>".$d[$_GET["day"]-1]."</p>";  
    }
?>