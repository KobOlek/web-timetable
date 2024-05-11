<?php

 if (isset($_GET['stud_id']))
 {      
         $sql_stud = "SELECT st_pib, st_birsday, st_stat, st_status, cl_name FROM stud, class where st_id=".$_GET['stud_id'];
         //echo $sql;
         $result_stud = $conn->query($sql_stud);
 
         if ($result_stud->num_rows > 0) 
         {
                 while ($row = $result_stud->fetch_assoc()) 
                 {
                  $st_pib=$row['st_pib'];
                  $st_birsday=$row['st_birsday'];
                  $st_stat=$row['st_stat'];
                  $st_status=$row['st_status'];
                  $cl_name=$row['cl_name'];
                 }
         }
         else{$st_pib=""; $st_birsday=""; $st_stat=""; $st_status=''; $cl_name=''; }
  
    echo "<b>Режим редагування запису про учня</b>";         
    echo "<form action='' method='post'>";
            
            
            echo "<table border=1>"; 
            echo "<th>назва</th>";
            echo "<th>поле</th>";

            echo "<tr>";
            echo "<td>";
            echo "прізвище, імя";
            echo "</td>";
            echo "<td>";
            echo "<input type='text' name='st_pib' value='".$st_pib."'>";
            echo "</td>";
            echo "</tr>";
    
            echo "<tr>";
            echo "<td>";
            echo "дата народження";
            echo "</td>";
            echo "<td>";
            echo "<input type='text' name='st_birsday' value='".$st_birsday."' maxlenght='10' size='10'><br>";
            echo "</td>";
            echo "</tr>";
    
            echo "<tr>";
            echo "<td>";
            echo "стать";
            echo "</td>";
            echo "<td>";
            echo "<select name='st_stat' value=''>";
                 if ($st_stat==''){echo "<option value='' selected>  </option>";}else{echo "<option value=''>  </option>";}
                 if ($st_stat=='ч'){echo "<option value='ч' selected>Ч</option>";}else{echo "<option value='ч'>Ч</option>";}
                 if ($st_stat=='ж'){echo "<option value='ж' selected>Ж</option>";}else{echo "<option value='ж'>Ж</option>";}           
                 echo "</select>";
            echo "</td>";
            echo "</tr>";
    
            echo "<tr>";
            echo "<td>";
            echo "статус";
            echo "</td>";
            echo "<td>";
            echo "<select name='st_status' value='$st_status'>";
                   if ($st_status==''){echo"<option value='' selected></option>";}else{echo "<option value=''>  </option>";}
                   if ($st_status=='навчається'){echo "<option value='навчається' selected> навчається </option>";}else{echo "<option value='навчається'>навчається</option>";}
                   if ($st_status=='за кордоном'){echo "<option value='за кордоном' selected> за кордоном </option>";}else{echo "<option value='за кордоном'>за кордоном</option>";}
                   if ($st_status=='вибув'){echo "<option value='вибув' selected> вибув</option>";}else{echo "<option value='вибув'>вибув</option>";}
            echo"</select><br>";  
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>";
            echo "клас";
            echo "</td>";
            echo "<td>";
            $sql_cl = "SELECT cl_id, cl_name FROM class where cl_name like '%".$_GET['cl']."%'";
            $result_cl = $conn->query($sql_cl);
            echo "<select name='class' id='class'>";               
            if ($result_cl->num_rows > 0) {
                    $ii=1; 
                    echo "<option value='0'>-</option>";
                    $sel="";
                    while ($row = $result_cl->fetch_assoc())
                    {
                            $sel="";
                            if($_GET['st']==$row['cl_id']){$sel=" selected";}else{$sel="";}
                                    echo "<option value='".$row['cl_id']."'".$sel.">".$row['cl_name']."</option>";   
                            }
                    } 
            echo "</select>";  
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan=2>";
            echo "<input type='submit' name='update_stud' value='update'>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</form>";
        //    
        //     echo "";  
            
        //     

        //     
        //      
        //      
        //     "</form>";                   
}
if (isset($_GET['insertinclass']))
 {
        echo "<b>Режим вставки запису про учня в клас </b>";
        echo "<form action='' method='post'>";
        echo "<table border=1>"; 
        echo "<th>назва</th>";
        echo "<th>поле</th>";
        echo "<tr>";
        echo "<td>";
        echo "прізвище, імя";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='insert_st_pib' value=''>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "дата народження";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='insert_st_birsday' value='' maxlenght='10' size='10'><br>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "стать";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<select name=стать>
        <option>  </option>
        <option value='ч'>ч</option>
        <option value='ж'>ж </option>
         </select>";
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo "статус";
        echo "</td>";
        echo "<td>";
        echo "<form action='' method='post'>";
        echo "<select name=статус>
        <option value='навчається'> навчається </option>
        <option value='за кордоном'> за кордоном </option>
        <option value='вибув'> вибув</option>
         </select>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
       
        echo ""; 
        
        echo "" ;
        echo "";
        echo "<input type='submit' name='insert_in_class' value='insert'>"; 
        echo "</form>"; 
        
      
             
 }
?>