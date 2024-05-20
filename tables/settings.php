<?php
    echo "<a href='?menu=admin&tb=9&user=create_student' class='btn btn-outline-success me-2'>Create student user</a>";
    echo "<a href='?menu=admin&tb=9&user=create_teacher' class='btn btn-outline-warning me-2'>Create teacher user</a>";

    if(isset($_GET["user"]))
    {
        if($_GET["user"] == "create_student")
        {
            $students = selectData("st_id", "stud", 
            "WHERE st_id NOT IN (SELECT us_email FROM users WHERE us_user_type = 3)")[0];
            while($student=mysqli_fetch_array($students))
            {
                insertData("users", 'us_email, us_password, us_user_type, verification_code', 
                "'".$student["st_id"]."','".md5($student["st_id"])."', 3, '".md5($student["st_id"])."'");
            }
        }

        if($_GET["user"] == "create_teacher")
        {
            $teachers = selectData("t_id", "teachers", 
            "WHERE t_id NOT IN (SELECT us_email FROM users WHERE us_user_type = 2)")[0];
            while($teacher=mysqli_fetch_array($teachers))
            {
                insertData("users", 'us_email, us_password, us_user_type, verification_code', 
                "'".$teacher["t_id"]."','".md5($teacher["t_id"])."', 2, '".md5($teacher["t_id"])."'");
            }
        }
    }
?>