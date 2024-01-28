<?php
    include('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="js/script.js"></script>
</head>
<body>
    <table border="1" width="100%">
        <caption>Адмін панель</caption>
        <tr>
            <th>
                <a href="<?php echo $_SERVER["PHP_SELF"];?>">Головна</a>
            </th>
            <th>
                <a href="?tb=1">Викладачі</a>
            </th>
            <th>
                <a href="?tb=2">Предмети</a>
            </th>
            <th>
                <a href="?tb=3">Класи</a>
            </th>
            <th>
                <a href="?tb=4">Кабінети</a>
            </th>
            <th>
                <a href="?tb=5">Предмети та класи</a>
            </th>
            <th>
                <a href="?tb=6">Вчителі та предмети</a>
            </th>
            <th>
                <a href="?tb=7">Фах вчителів</a>
            </th>
            <th>
                <a href="?tb=8">Розклад</a>
            </th>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <?php
                    $tablesPaths = [
                        "tables/teachers.php", "tables/subjects.php", "tables/classes.php", "tables/cabinets.php",
                        "tables/subjectsAndClasses.php", "tables/teachersAndClasses.php", "tables/teachersProfession.php",
                        "tables/timetable.php"
                    ];
                    for ($i=0; $i < count($tablesPaths); $i++) {
                        if(isset($_GET["tb"])){
                            if(($_GET["tb"] == $i+1))
                                include($tablesPaths[$i]);
                        }
                        elseif(isset($_GET["edit"])){
                            if($_GET["edit"] == $i+1)
                                include($tablesPaths[$i]);
                        }
                    }
                ?>
            </td>
        </tr>
    </table>
</body>
</html>