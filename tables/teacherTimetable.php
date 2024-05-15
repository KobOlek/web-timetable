<title>Розклад вчителів</title>
<?php
    include("config.php");
    $result_array = selectData("*", "teachers")[0];
?>
<div>
    <h1>
        Розклад вчителів
    </h1>
    <table  class="">
        <tr>
            <th rowspan='2'>#</th>
            <th rowspan='2'>ПІБ</th>
            <th rowspan='2'>Телефон</th>
            <?php
                $days = ["Понеділок", "Вівторок", "Середа", "Четвер", "П'ятниця"];
                for($day=0; $day < count($days); $day++)
                {
                    echo "<th colspan='8'>$days[$day]</th>";
                }
            ?>
        </tr>
        <tr>
            <?php
                for($k=0; $k < 5; $k++)
                {
                    for($g=1; $g <= 8; $g++)
                    {
                        echo "<th>$g</th>";
                    }
                }
            ?>
        </tr>
        <?php
            while($teachersArray = mysqli_fetch_array($result_array)){
                list($amount_of_occupied_hours) = mysqli_fetch_array(
                    selectData("COUNT(*)", "timetable", 
                    "WHERE tt_id_teach = ".$teachersArray["t_id"])[0]);
                echo "
                <tr>
                    <td>".$teachersArray["t_id"]."</td>
                    <td>".$teachersArray["t_fullname"]."</td>
                    <td>".$teachersArray["t_email"]."</td>";

                for($i_day=1; $i_day <= 5; $i_day++)
                {
                    for($num_lesson=1; $num_lesson <= 8; $num_lesson++)
                    {
                        list($class_name, $cabinet_number) = mysqli_fetch_array(
                            selectData("c_name, cab_num", "timetable, classes, cabinets", "WHERE tt_class_id = c_id AND tt_num_lesson = $num_lesson 
                            AND tt_day_id = $i_day AND tt_id_teach = ".$teachersArray["t_id"]." AND tt_cabinet_id = cab_id")[0]
                        );
                        if($class_name == '')
                            echo "<td style='background: grey; color: lightgrey; text-align: center;'>&#160 - &#160</td>";
                        else
                            echo "<td style='background: green; color: lime;'>
                        <abbr style='text-decoration: none;' title='Кабінет: ".$cabinet_number."'>
                        ".$class_name."</abbr></td>";
                    }
                }
                echo "</tr>";
            }
        ?>
</table>
</div>