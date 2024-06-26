<?php
    include('Auth/config.php');
?>

<head>
    <title>Admin</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>            
</head>
<body>
    <table class="table table-striped" border="1" width="100%">
        <caption>Адмін панель</caption>
        <tr>
            <th>
                <a href="index.php">Головна</a>
            </th>
            <th>
                <a href="?menu=admin&tb=1">Викладачі</a>
            </th>
            <th>
                <a href="?menu=admin&tb=2">Предмети</a>
            </th>
            <th>
                <a href="?menu=admin&tb=3">Класи</a>
            </th>
            <th>
                <a href="?menu=admin&tb=4">Кабінети</a>
            </th>
            <th>
                <a href="?menu=admin&tb=9">Налаштування</a>
            </th>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <?php
                    $tablesPaths = [
                        "tables/teachers.php", "tables/subjects.php", "tables/classes.php", "tables/cabinets.php",
                        "tables/subjectsAndClasses.php", "tables/teachersAndClasses.php", "tables/teachersProfession.php",
                        "tables/timetable.php", "tables/settings.php"
                    ];
                    for ($i=0; $i < count($tablesPaths); $i++) {
                        if(isset($_GET["tb"])){
                            if(($_GET["tb"] == $i+1))
                                include($tablesPaths[$i]);
                            //echo $tablesPaths[$i]." ".$i;
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
    <script src="script.js"></script>
</body>