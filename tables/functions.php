
<?php
    function selectData($column, $table_name, $condition=""){
        $sql_request = "SELECT ".$column." FROM ".$table_name." ".$condition;
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        return [$sql_result_array, $sql_request];
    }

    function redirectTo($url){
        header("Location: ".$url);
        die();
    }

    function insertData($table_name, $table_columns, $insert_values){
        $sql_insert = "INSERT INTO ".$table_name."(".$table_columns.") VALUES (".$insert_values.")";
        echo $sql_insert;
        $result = mysqli_query($GLOBALS['link'], $sql_insert);
    }

    function updateData($subject_id, $class_id, $hours, $id){
        $sql_request = 
        "UPDATE subjectsandclasses SET s_id = ".$subject_id.", c_id = ".$class_id.", sc_hours_count = ".$hours." WHERE sc_id = '".$id."'";
        echo $sql_request;
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }

    function deleteData($table_name, $condition){
        $sql_request = "DELETE FROM ".$table_name." ".$condition;
        $result = mysqli_query($GLOBALS["link"], $sql_request);

        if(!$result){
            echo mysqli_error($GLOBALS["link"]);
        }
    }
?>