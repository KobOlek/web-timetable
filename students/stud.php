<link href="../css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="../style.css" rel="stylesheet">
<script src="../js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>            
<?php
        include("./config.php");

        $type_user = 1; //1 = адмін

        $sql = "SELECT st_pib, st_id FROM stud where st_id=".$_GET['stud'];
        //echo $sql;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            list($tt)=$result->fetch_array();
        } else {
                echo "не знайдено жодного запису";
        }
    //=============================================================================================================================================================================================================================================================================================================================================================================
        if (isset($_POST['sub_tex_stud']))        {
                    
            $sql_upd = "UPDATE stud SET st_cl_id=".$_POST['class'].", st_pib='".$_POST['text_pib']."', st_birsday='".$_POST['text_dn']."', st_stat='".$_POST['st_stat']."', st_status='".$_POST['st_status']."' WHERE st_id=".$_GET['stud'];
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    //=============================================================================================================================================================================================================================================================================================================================================================================
        if (isset($_POST['ins_con_stud']))        {
                        
            $sql_upd = "INSERT INTO contact(co_stud_id, co_nomer, co_email)values(".$_GET['stud'].", '".$_POST['text_nomer_phone']."', '".$_POST['text_email']."')";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
        if (isset($_POST['up_con_stud']))        {
                        
            $sql_upd = "UPDATE contact SET co_nomer='".$_POST['text_nomer_phone']."', co_email='".$_POST['text_email']."' WHERE co_stud_id=".$_GET['stud'];
            echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
    //=============================================================================================================================================================================================================================================================================================================================================================================
    
        if (isset($_POST['ins_doc_stud'])) 
        {

            if(isset($_GET['tupdoc']))
            {
              if($_GET['tupdoc']=='svid')
              {
                $tupdoc=1;
                $sql_upd = "INSERT INTO document(d_st_id, d_tup, d_seria, d_nomer, d_kolu_vydano) ".
                            "values(".$_GET['stud'].",".$tupdoc.",'".$_POST['text_seria']."', ".$_POST['text_nomer_dokumentu'].",'".$_POST['text_kolu_vydano']."')";
              }
              if($_GET['tupdoc']=='passpost'){
                $tupdoc=2;
                $sql_upd = "INSERT INTO document(d_st_id, d_tup, d_nomer, d_kym_vydano, d_kolu_vydano) ".
                "values(".$_GET['stud'].",".$tupdoc.",'".$_POST['text_nomer_dokumentu']."','".$_POST['text_kim_vydano']."','".$_POST['text_kolu_vydano']."')";
            }
              if($_GET['tupdoc']=='ipn')
              {
                $tupdoc=3;
                $sql_upd = "INSERT INTO document(d_st_id, d_tup, d_ipn)values(".$_GET['stud'].",".$tupdoc.", '".$_POST['text_ipn']."')";
              }
            }

            //$sql_upd = "INSERT INTO document(d_st_id, d_tup, d_seria, d_nomer, d_kym_vydano, d_kolu_vydano, d_skan, d_ipn)values(".$_GET['stud'].",".$tupdoc.",'".$_POST['text_seria']."', ".$_POST['text_nomer_dokumentu'].",  '".$_POST['text_kim_vydano']."',  '".$_POST['text_kolu_vydano']."',  '".$_POST['text_skan_dokumentu']."', '".$_POST['text_ipn']."')";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
        if (isset($_POST['up_doc_stud']))        
        {

            if(isset($_GET['tupdoc']))
            {
              if($_GET['tupdoc']=='svid')
              {
                $sql_upd = "UPDATE document SET d_seria='".$_POST['text_seria']."', d_nomer='".$_POST['text_nomer_dokumentu']."', d_kolu_vydano='".$_POST['text_kolu_vydano']."' WHERE d_st_id=".$_GET['stud']." and d_tup=1";
              }

              if($_GET['tupdoc']=='passpost')
              {
                $sql_upd = "UPDATE document SET d_nomer='".$_POST['text_nomer_dokumentu']."', d_kym_vydano='".$_POST['text_kim_vydano']."', d_kolu_vydano='".$_POST['text_kolu_vydano']."' WHERE d_st_id=".$_GET['stud']." and d_tup=2";
              }

              if($_GET['tupdoc']=='ipn')
              {
                $sql_upd = "UPDATE document SET d_ipn='".$_POST['text_ipn']."' WHERE d_st_id=".$_GET['stud']." and d_tup=3";
              }
            }               
          
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
    //=============================================================================================================================================================================================================================================================================================================================================================================
    
        if (isset($_POST['ins_con_father']))        {
            $sql_upd = "INSERT INTO parants(p_gender, p_st_id, p_name, p_nomer, p_email)values(1, ".$_GET['stud'].", '".$_POST['text_pib_f']."', '".$_POST['text_nomer_telofonu_f']."',  '".$_POST['text_email_f']."')";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
        if (isset($_POST['up_con_father']))        {
                        
            $sql_upd = "UPDATE parants SET p_name='".$_POST['text_pib_f']."', p_nomer='".$_POST['text_nomer_telofonu_f']."',  p_email='".$_POST['text_email_f']."' WHERE p_st_id=".$_GET['stud']." and p_gender=1";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
    //=============================================================================================================================================================================================================================================================================================================================================================================
    
        if (isset($_POST['ins_con_mother']))        {
            $sql_upd = "INSERT INTO parants(p_gender, p_st_id, p_name, p_nomer, p_email)values(2, ".$_GET['stud'].", '".$_POST['text_pib_m']."', '".$_POST['text_nomer_m']."',  '".$_POST['text_email_m']."')";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
        if (isset($_POST['up_con_mother']))        {
                        
            $sql_upd = "UPDATE parants SET p_name='".$_POST['text_pib_m']."', p_nomer='".$_POST['text_nomer_m']."',  p_email='".$_POST['text_email_m']."' WHERE p_st_id=".$_GET['stud']." and p_gender=2";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
    //=============================================================================================================================================================================================================================================================================================================================================================================    
    if (isset($_POST['ins_rei_stud']))        {
        $sql_upd = "INSERT INTO adress(ad_st_id, ad_cod, ad_vyl)values(".$_GET['stud'].",".$_POST['sity'].", '".$_POST['text_misce_prozhyvanya']."')";
        //echo $sql_upd;
        $result_upd = $conn->query($sql_upd);
    }
   
    if (isset($_POST['up_rei_stud']))        {
                    
        $sql_upd = "UPDATE adress SET ad_cod=".$_POST['sity'].", ad_vyl='".$_POST['text_misce_prozhyvanya']."' WHERE ad_st_id=".$_GET['stud'];
        //echo $sql_upd;
        $result_upd = $conn->query($sql_upd);
    }
      
    //=============================================================================================================================================================================================================================================================================================================================================================================    
      $id = $_GET['stud'];
    $upload_file = "photo/".$id."/";

    $status_="";
    if(isset($_GET['tupdoc']))
    {
    if($_GET['tupdoc']=='svid'){$status_="Завантаження скану свідоцтва про народження"; $namefile="01_svid_";}
    if($_GET['tupdoc']=='passpost'){$status_="Завантаження скану паспорта"; $namefile="02_pasp_"; }
    if($_GET['tupdoc']=='ipn'){$status_="Завантаження скану ІНП"; $namefile="03_ipn_"; }
    }else{$status_="Завантаження фото"; $namefile="photo";}
    //----------------------------------
    if(isset($_POST['upload']))
    {
       
        if(!file_exists("photo/".$id)) {mkdir("photo/".$id."");}
        
        if(isset($_POST['upload']))  
        {	
            if(file_exists($upload_file.$namefile.$id.".jpeg")){unlink($upload_file.$namefile.$id.".jpeg");	}
                				
                $tmp_file = $_FILES['img_upload']['tmp_name'];
                move_uploaded_file($tmp_file, $upload_file.$namefile.$id.".jpeg");							
        } 
    }  
    //=============================================================================================================================================================================================================================================================================================================================================================================    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo "Сторінка учня: ".$tt; ?></title>
</head>
<body>
        <div align=center><?php echo "<h4>"."Сторінка учня: ".$tt."</h4>"; ?></div>
        <table class="table table-striped" border="1" align="center" width="750px"> 
            <tr>
                <td width="20%" align=center>
				<?php				

                    if(file_exists($upload_file."photo".$id.".jpeg"))
                    {
                        echo "<img src='".$upload_file."photo".$id.".jpeg' width='114px' alt='ФОТОГРАФІЯ'>";  // 1 см - 38 пікселів
                    }
                    else{
                        echo "<img src='photo/siluet_man.png' alt='ФОТОГРАФІЯ' width='114px'>";
                    }	
		
        ?>    
        </td>
                <td>
                <form action="" method="post">    
                    <table>  
                        <tr>
                            <td>
                                ПІБ:
                            </td>
                            <td>
                                <?php                              
                                    $sql = "SELECT st_pib, st_birsday, st_stat, st_status, cl_id, cl_name, st_cl_id FROM stud, class where cl_id=st_cl_id and st_id=".$_GET['stud'];
                                    //echo $sql;
                                    $result = $conn->query($sql);
                            
                                    if ($result->num_rows > 0) {
                                        list($st_pib, $st_birsday, $st_stat, $st_status, $cl_id, $cl_name, $st_cl_id)= $result->fetch_array(); 
                                        //echo $st_cl_id;
                                    }
                                    else{$st_pib='';
                                         $st_birsday=''; 
                                         $st_stat=''; 
                                         $st_status=''; 
                                         $cl_id=''; 
                                         $cl_name='';
                                         $st_cl_id='';   
                                    }
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_pib' value='$st_pib'>";
                                    }
                                    else {
                                        echo "<b>$st_pib</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                ДН:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_dn' value='$st_birsday'>";
                                    }
                                    else {
                                        echo "<b>$st_birsday</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>                               
                                Стать:
                            </td>
                            <td>  
                                <?php
                                    if($type_user == 1) {

                                        echo "<select name='st_stat' value=''>";
                                            if ($st_stat==''){echo "<option value='' selected>  </option>";}else{echo "<option value=''>  </option>";}
                                            if ($st_stat=='ч'){echo "<option value='ч' selected>Ч</option>";}else{echo "<option value='ч'>Ч</option>";}
                                            if ($st_stat=='ж'){echo "<option value='ж' selected>Ж</option>";}else{echo "<option value='ж'>Ж</option>";}           
                                        echo "</select>";
                                    }
                                    else {
                                        echo "<b>$st_stat</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Статус:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {

                                        echo "<select name='st_status' value='$st_status'>";
                                            if ($st_status==''){echo"<option value='' selected></option>";}else{echo "<option value=''>  </option>";}
                                            if ($st_status=='Навчається'){echo "<option value='Навчається' selected> Навчається </option>";}else{echo "<option value='Навчається'>Навчається</option>";}
                                            if ($st_status=='За кордоном'){echo "<option value='За кордоном' selected> За кордоном </option>";}else{echo "<option value='За кордоном'>За кордоном</option>";}
                                            if ($st_status=='Вибув'){echo "<option value='Вибув' selected> Вибув</option>";}else{echo "<option value='Вибув'>Вибув</option>";}
                                        echo"</select>";
                                    }
                                    else {
                                        echo "<b>$st_status</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Клас:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                       $sql = "SELECT cl_id, cl_name FROM class";
                                        //echo $sql;
                                        $result = $conn->query($sql);
                                        echo "<select name='class' id='class'>";               
                                        if ($result->num_rows > 0) 
                                        {
                                                $ii=1; 
                                                echo "<option value='0'>-</option>";
                                                $sel="";
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    $sel="";
                                                    if($st_cl_id==$row['cl_id']){$sel=" selected";}else{$sel="";}
                                                    echo "<option value='".$row['cl_id']."'".$sel.">".$row['cl_name']."</option>";   
                                                }
                                         } 
                                        echo "</select>";                                     
                                        }
                                    else {
                                        echo "<b>$cl_name</b>";
                                    }
                                ?>    
                            </td>
                        </tr>
                    </table>
                    <?php
                        if($type_user == 1) {
                            echo "<input type='submit' name='sub_tex_stud' value='Оновити'>";                          
                        }
                    ?>
                    
                </td>
            </tr>
            </form>
            <?php
              if($type_user == 1) 
              {     
                ?>
                <tr>
                <td colspan="2">

                     <form action="" method="post" enctype="multipart/form-data">
                       <b><?php echo $status_;?></b><br>
			           <input type="file" name="img_upload">
                       <input type="submit" name="upload" value="Загрузити">
	                </form>

                </td>
                </tr>
                <form action="" method="post">
                <?php
              }
                $sql = "SELECT co_nomer, co_email FROM contact where co_stud_id=".$_GET['stud'];
                //echo $sql;
                $result = $conn->query($sql);      
                if ($result->num_rows > 0) {
                    list($co_nomer, $co_email)= $result->fetch_array(); 
                    //echo $st_cl_id;
                }
                else{  
                    $co_nomer='';
                    $co_email='';
                }
            ?>
            <tr>
                <td>
                    Контакні дані учня:
                </td>
                <td>
                    <table>

                        <tr>
                            <td>
                                Номер телефону:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_nomer_phone' value='$co_nomer'>";
                                    }
                                    else {
                                        echo "<b>$co_nomer</b>";
                                    }
                                ?>    
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_email' value='$co_email' width='100'>";
                                    }
                                    else {
                                            echo "<b>$co_email</b>";
                                    }
                                ?>  
                            </td>
                        </tr>
                    </table>
                    <?php
                        if($type_user == 1) {
                           if ($co_email=="")
                           {echo "<input type='submit' name='ins_con_stud' value='Добавити'>";}
                           else
                           { echo "<input type='submit' name='up_con_stud' value='Оновити'>";}                  
                        }
                    ?>
                </td>
            </tr>
            <?php
                if(isset($_GET['tupdoc']))
                {
                if($_GET['tupdoc']=='svid'){$sql_tup=" and d_tup=1";}
                if($_GET['tupdoc']=='passpost'){$sql_tup=" and d_tup=2";}
                if($_GET['tupdoc']=='ipn'){$sql_tup=" and d_tup=3";}
                }else{$sql_tup="";}

                $sql = "SELECT d_id, d_seria, d_nomer, d_kym_vydano, d_kolu_vydano, d_ipn FROM document where d_st_id=".$_GET['stud'].$sql_tup;
                //echo $sql;
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    list($d_id, $d_seria, $d_nomer, $d_kym_vydano, $d_kolu_vydano, $d_ipn)= $result->fetch_array(); 
                    //echo $st_cl_id;
                }
                else{
                    $d_id='';
                    $d_seria='';
                    $d_nomer='';
                    $d_kym_vydano='';
                    $d_kolu_vydano='';
                    $d_ipn='';
                }
            ?>
            <tr>
                <td>
                    Документи:
                    <?php 
                    if($type_user == 1) 
                    { 
                        ?>
                        <a href='stud.php?stud=<?php echo $_GET['stud']?>'>Перегляд</a><br>
                        <a href='stud.php?stud=<?php echo $_GET['stud']?>&tupdoc=svid'>Свідоцтво про народження</a><br>
                        <a href='stud.php?stud=<?php echo $_GET['stud']?>&tupdoc=passpost'>Паспорт:</a><br>
                        <a href='stud.php?stud=<?php echo $_GET['stud']?>&tupdoc=ipn'>ІПН</a><br>
                        <?php
                    }   
                    ?>
                </td>
                <td>
                    <table>
                    
                        <?php 
                           if(isset($_GET['tupdoc']))
                           {
                            echo "<tr><td colspan=2>";
                            if($_GET['tupdoc']=='svid'){$nazvadoc="Свідоцтво про народження";}
                            if($_GET['tupdoc']=='passpost'){$nazvadoc="Паспорт";}
                            if($_GET['tupdoc']=='ipn'){$nazvadoc="Ідентифікаційний код";}

                            echo "<b>Обрано документ - ".$nazvadoc."</b>";
                            echo "</td></tr>";
                           }
                        ?>
                     

                     <?php 
                     if(isset($_GET['tupdoc']))
                     {
                        if($_GET['tupdoc']=='svid')
                        {?>
                     <tr>
                            <td >
                                Серія:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_seria' value='".$d_seria."'>";
                                    }
                                    else {
                                        echo "<b>$d_seria</b>";
                                    }
                                ?>    
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Номер документу:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_nomer_dokumentu' value='".$d_nomer."'>";
                                    }
                                    else {
                                        echo "<b>$d_nomer</b>";
                                    }
                                ?>       
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Коли видано:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_kolu_vydano' value='$d_kolu_vydano'>";
                                    }
                                    else {
                                        echo "<b>$d_kolu_vydano</b>";
                                    }
                                ?> 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Скан документа:
                            </td>
                            <td>
                                <?php
                                    if(file_exists($upload_file."01_svid_".$id.".jpeg"))     
                                    {
                                        $rr=$upload_file."01_svid_".$id.".jpeg";
                                        //echo $rr; 
                                        echo "<a href='".$rr."' target=_blank> Скан існує</a>";  // 1 см - 38 пікселів
                                    }
                                    else{
                                        echo "Скан відсутній";
                                    }	
                                ?>
                            </td>
                        </tr>                            
                               
                        <?php }
                        if($_GET['tupdoc']=='passpost')
                        {?>

                        <tr>
                            <td>
                                Номер документу:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_nomer_dokumentu' pattern='[0-9]{10}' value='$d_nomer'>";
                                    }
                                ?>       
                            </td>
                        </tr>

                        <tr>
                            <td>                               
                                Ким видано:
                            </td>
                            <td>   
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_kim_vydano' pattern='[0-9]{4}' value='$d_kym_vydano'>";
                                    }
                                ?>       
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Коли видано:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_kolu_vydano' value='$d_kolu_vydano'>";
                                    }
                                ?> 
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Скан документа:
                            </td>
                            <td>
                              <?php
                                if(file_exists($upload_file."02_pasp_".$id.".jpeg"))
                                {
                                    echo "Скан існує";  // 1 см - 38 пікселів
                                }
                                else{
                                    echo "Скан відсутній";
                                }	
                              ?>
                            </td>
                        </tr>                            
                              
                            <?php 
                        }

                        if($_GET['tupdoc']=='ipn')
                        {?>

                        <tr>
                            <td>
                                ІПН:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_ipn' maxvalue='10' pattern='[0-9]{10}' value='$d_ipn'>";    
                                    }  
                                    else {
                                        echo "<b>$d_ipn</b>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Скан документа:
                            </td>
                            <td>
                              <?php
                              if(file_exists($upload_file."03_ipn_".$id.".jpeg"))
                              {
                                  echo "Скан існує";  // 1 см - 38 пікселів
                              }
                              else{
                                  echo "Скан відсутній";
                              }	
                                ?>
                            </td>
                        </tr>
                               
                        <?php 
                      }

                        if($type_user == 1) 
                        {
                          echo "<tr><td colspan=2>";
                          if($d_id == "") {
                              echo "<input type='submit' name='ins_doc_stud' value='Добавити'>";
                          } 
                          else {
                              echo "<input type='submit' name='up_doc_stud' value='Оновити'>";
                          }
                          echo "</td></tr>";  
                        } 
                    }
                    else
                    {
                        echo "<tr><td colspan=2>";
                        $sql = "SELECT d_id, d_tup, d_seria, d_nomer, d_kym_vydano, d_kolu_vydano, d_ipn FROM document where d_st_id=".$_GET['stud']." order by d_tup";
                        //echo $sql;
                        $result = $conn->query($sql);
                
                        if ($result->num_rows > 0) 
                        {
                            while($res= $result->fetch_array()) 
                            {
                              if ($res['d_tup']==1) 
                              {
                                $sc_svid="";
                                if(file_exists($upload_file."01_svid_".$id.".jpeg"))// 1 см - 38 пікселів
                                {$sc_svid=" (Скан присутній)";}else{$sc_svid=" (Скан відсутній)";}  

                                echo "<p>Свідоцтво про народження: <b>".$res['d_seria']." №".$res['d_nomer']." Дата видачі: ".$res['d_kolu_vydano'].$sc_svid."</b></p>";
                              }
                              if ($res['d_tup']==2) 
                              {
                                $sc_pas="";
                                if(file_exists($upload_file."02_pasp_".$id.".jpeg"))// 1 см - 38 пікселів
                                {$sc_pas=" (Скан присутній)";}else{$sc_pas=" (Скан відсутній)";}  

                                echo "<p>ID-картка: <b>№".$res['d_nomer']." Ким видано:".$res['d_kym_vydano']." Дата видачі: ".$res['d_kolu_vydano'].$sc_pas."</b></p>";
                              }
                              if ($res['d_tup']==3) 
                              {                             
                                $sc_ipn="";
                                if(file_exists($upload_file."03_ipn_".$id.".jpeg"))// 1 см - 38 пікселів
                                {$sc_ipn=" (Скан присутній)";}else{$sc_ipn=" (Скан відсутній)";}                                

                                echo "<p>ІПН: <b>№".$res['d_ipn'].$sc_ipn."</b></p>";
                              }                             
                            }
                        }
                        else{echo "Документи ще не внесено!!!";}
                        
                        
                        echo "</td></tr>"; 
                    }
                    ?>      
                    </table>
                </td>
            </tr> 

            <tr>
                <?php
                     $sql = "SELECT ad_cod, ad_vyl, ad_st_id, city_name, oth_name, city_type FROM adress, adress_city, adress_oth where oth_id=city_oth_id and ad_cod=city_id and ad_st_id=".$_GET['stud'];
                     //echo $sql;
                     $result = $conn->query($sql);      
                     if ($result->num_rows > 0) {
                         list($ad_cod, $ad_vyl, $ad_st_id, $city_name, $oth_name, $city_type)= $result->fetch_array(); 
                         }
                     else{  
                         $ad_cod='';
                         $ad_vyl='';
                     }              
                 ?>
                <td colspan="2">Місце проживання: 
                    <?php
                    if($type_user == 1) {
                        $sql = "SELECT city_id, city_name FROM adress_city order by city_type, city_name";
                        //echo $sql;
                        $result = $conn->query($sql);
                        echo "<select name='sity' id='sity'>";               
                        if ($result->num_rows > 0) 
                        {
                                $ii=1; 
                                echo "<option value='0'>-</option>";
                                $sel="";
                                while ($row = $result->fetch_assoc())
                                {
                                    $sel="";
                                    if($ad_cod==$row['city_id']){$sel=" selected";}else{$sel="";}
                                    echo "<option value='".$row['city_id']."'".$sel.">".$row['city_name']."</option>";   
                                }
                        } 
                        echo "</select>";   
                        echo "<input type='text' name='text_misce_prozhyvanya' value='".$ad_vyl."'>";
                        }
                    else {
                        echo "<b>".$oth_name.", ".$city_type." ".$city_name.", ";
                        echo " вул.".$ad_vyl."</b>";
                    }
                        if($type_user == 1) {
                           }
                        else {
                            
                        }
                    ?>
                    <?php
                        if($type_user == 1) {
                          //  echo "<input type='text' name='text_misce_prozhyvanya' value=''>"."<br>";
                          if($ad_cod =='')
                          {echo "<input type='submit' name='ins_rei_stud' value='Добавити'>";}
                          else{echo "<input type='submit' name='up_rei_stud' value='Оновити'>"; } 
                        } 
                    ?>
                </td>
            </tr>
        
            <tr>
                <td>
                    Батьки:
                </td>
                <td>
                    <?php
                        $sql = "SELECT p_name, p_nomer, p_email FROM parants where p_gender=1 and p_st_id=".$_GET['stud'];
                        //echo $sql;
                        $result = $conn->query($sql);
                
                        if ($result->num_rows > 0) {
                            list($p_namef, $p_nomerf, $p_emailf)= $result->fetch_array(); 
                            //echo $st_cl_id;

                        }
                        else{  
                            $p_namef='';
                            $p_nomerf='';
                            $p_emailf='';
                        }
                        //////////////////////////////////////////////////////////////////////////////////////////////////////
                        $sql = "SELECT p_name, p_nomer, p_email FROM parants where  p_gender=2 and p_st_id=".$_GET['stud'];
                        //echo $sql;
                        $result = $conn->query($sql);
                
                        if ($result->num_rows > 0) {
                            list($p_namem, $p_nomerm, $p_emailm)= $result->fetch_array(); 
                            //echo $st_cl_id;

                        }
                        else{  
                            $p_namem='';
                            $p_nomerm='';
                            $p_emailm='';
                        }
                    ?>
                    <table>
                        <tr>
                            <td>#</td>
                             <td>
                                Тато:
                            </td>
                            <td>
                                Мама:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ПІБ:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_pib_f' value='$p_namef'>";
                                    }
                                    else {
                                        echo "<b>$p_namef</b>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_pib_m' value='$p_namem'>";
                                    }
                                    else {
                                        echo "<b>$p_namem</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Номер телефону:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_nomer_telofonu_f' value='$p_nomerf'>";
                                    }
                                    else {
                                        echo "<b>$p_nomerf</b>";
                                    }
                                ?>       
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_nomer_m' value='$p_nomerm'>";
                                    }
                                    else {
                                        echo "<b>$p_nomerm</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Email:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_email_f' value='$p_emailf'>";
                                    }
                                    else {
                                        echo "<b>$p_emailf</b>";
                                    }
                                ?>
                            </td>

                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_email_m' value='$p_emailm'>";
                                    }
                                    else {
                                        echo "<b>$p_emailm</b>";
                                    }
                                ?>
                            </td>
                        </tr>
                     <tr>
                        <td>#</td>
                        <td>
                    <?php
                        if($type_user == 1) {
                            if($p_namef=="") {
                            echo "<input type='submit' name='ins_con_father' value='Добавити'>";
                            }
                            else {
                            echo "<input type='submit' name='up_con_father' value='Оновити'>";
                            }
                        echo "</td><td>";

                            if($type_user == 1) {
                                if($p_namem=="") {
                                    echo "<input type='submit' name='ins_con_mother' value='Добавити'>";
                                }
                                else {
                                    echo "<input type='submit' name='up_con_mother' value='Оновити'>";
                                }
                            }
                        }
                    ?>
                    </td></tr>
                   </table>
                </td>
            </tr>
        </table>
        
    </form>
</body>
</html>