
<?php
    function selectData($column, $table_name, $condition=""){
        $sql_request = "SELECT ".$column." FROM ".$table_name." ".$condition;
        //echo $sql_request;
        $sql_result_array = mysqli_query($GLOBALS['link'], $sql_request);
        return [$sql_result_array, $sql_request];
    }

    function redirectTo($url){
        header("Location: ".$url);
        die();
    }

    function insertData($table_name, $table_columns, $insert_values){
        $sql_insert = "INSERT INTO ".$table_name."(".$table_columns.") VALUES (".$insert_values.")";
        //echo $sql_insert."<br>";
        $result = mysqli_query($GLOBALS['link'], $sql_insert);
    }

    function updateData($table_name, $table_columns, $insert_values, $condition){
        $set_string = "";
        for ($i=0; $i < count($table_columns); $i++) { 
            $set_string .= $table_columns[$i]." = ".$insert_values[$i];
        }
        $sql_request = 
        "UPDATE ".$table_name." SET ".$set_string." ".$condition;
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