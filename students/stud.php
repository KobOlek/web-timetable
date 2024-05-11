<?php
        include("config.php");

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
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
    //=============================================================================================================================================================================================================================================================================================================================================================================
    
        if (isset($_POST['ins_doc_stud']))        {
            $sql_upd = "INSERT INTO document(d_st_id, d_seria, d_nomer, d_kym_vydano, d_kolu_vydano, d_skan, d_ipn)values(".$_GET['stud'].", '".$_POST['text_seria']."', ".$_POST['text_nomer_dokumentu'].",  '".$_POST['text_kim_vydano']."',  '".$_POST['text_kolu_vydano']."',  '".$_POST['text_skan_dokumentu']."', '".$_POST['text_ipn']."')";
            //echo $sql_upd;
            $result_upd = $conn->query($sql_upd);
        }
    
        if (isset($_POST['up_doc_stud']))        {
                        
            $sql_upd = "UPDATE document SET d_seria='".$_POST['text_seria']."', d_nomer=".$_POST['text_nomer_dokumentu'].",  d_kym_vydano='".$_POST['text_kim_vydano']."',  d_kolu_vydano='".$_POST['text_kolu_vydano']."',  d_skan='".$_POST['text_skan_dokumentu']."', d_ipn='".$_POST['text_ipn']."' WHERE d_st_id=".$_GET['stud'];
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo "Сторінка учня: ".$tt; ?></title>
</head>
<body>
    <form action="" method="post">
        <?php
            $sql = "SELECT st_pib, st_birsday, st_stat, st_status, cl_id, cl_name, st_cl_id FROM stud, class where cl_id=st_cl_id and st_id=".$_GET['stud'];
            //echo $sql;
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                list($st_pib, $st_birsday, $st_stat, $st_status, $cl_id, $cl_name, $st_cl_id)= $result->fetch_array(); 
                //echo $st_cl_id;
            }
            else
            {
                $st_pib='';
                $st_birsday=''; 
                $st_stat=''; 
                $st_status=''; 
                $cl_id=''; 
                $cl_name='';
                $st_cl_id='';   
            }
        
        echo '<a href="?menu=students&cl='.$cl_name.'&st='.$st_cl_id.'&stud_id='.$_GET["stud"].'">Назад до класу</a>';
        echo "<h1 style='text-align: center;'>"."Сторінка учня: ".$tt."</h1>"; 
        ?>
        <table border="1" align="center" width="800px">
            <tr>
                <td width="20%">
                    <img src="students/photo/siluet_man.png" alt="ФОТОГРАФІЯ" width="80%">
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                ПІБ:
                            </td>
                            <td>
                                <?php
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
                                        echo "<b>23.07.2010(14)</b>";
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
                                        if ($result->num_rows > 0) {
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
                                        echo "<b></b>";
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

            <?php
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
                $sql = "SELECT d_seria, d_nomer, d_kym_vydano, d_kolu_vydano, d_ipn, d_skan FROM document where d_st_id=".$_GET['stud'];
                //echo $sql;
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {
                    list($d_seria, $d_nomer, $d_kym_vydano, $d_kolu_vydano, $d_ipn, $d_skan)= $result->fetch_array(); 
                    //echo $st_cl_id;

                }
                else{  
                    $d_seria='';
                    $d_nomer='';
                    $d_kym_vydano='';
                    $d_kolu_vydano='';
                    $d_ipn='';
                    $d_skan='';
                }
            ?>
            <tr>
                <td>Документ що підсвічує особу:</td>
                <td>
                    <table>
                    <tr>
                            <td>
                                Серія:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_seria' value='$d_seria'>";
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
                                        echo "<input type='text' name='text_nomer_dokumentu' value='$d_nomer'>";
                                    }
                                    else {
                                        echo "<b>$d_nomer</b>";
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
                                        echo "<input type='text' name='text_kim_vydano' value='$d_kym_vydano'>";
                                    }
                                    else {
                                        echo "<b>$d_kym_vydano</b>";
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
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_skan_dokumentu' value='$d_skan'>";
                                    }
                                    else {
                                        echo "<b>$d_skan</b>";
                                    }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                ІПН:
                            </td>
                            <td>
                                <?php
                                    if($type_user == 1) {
                                        echo "<input type='text' name='text_ipn' maxvalue='10' value='$d_ipn'>";
                                    }
                                    else {
                                        echo "<b>$d_ipn</b>";
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                        if($type_user == 1) {
                            if($d_ipn == "") {
                                echo "<input type='submit' name='ins_doc_stud' value='Добавити'>";
                            } 
                            else {
                                echo "<input type='submit' name='up_doc_stud' value='Оновити'>";
                            }
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">Місце проживання: 
                    <?php
                        if($type_user == 1) {
                            echo "<input type='text' name='text_misce_prozhyvanya' value=''>";}
                        else {
                            echo "<b>Дрогобич, Пилипа Орлика 13</b>";
                        }
                    ?>
                    <?php
                        if($type_user == 1) {
                          //  echo "<input type='text' name='text_misce_prozhyvanya' value=''>"."<br>";
                            echo "<input type='submit' name='ins_rei_stud' value='Добавити'>";
                            echo "<input type='submit' name='up_rei_stud' value='Оновити'>";
                        }
                        else {
                            echo "<b>Львів, Пилипа Орлика 13</b>";
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
                    ?>
                    <table>
                        <tr>
                            <td>
                                Тато:
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
                        </tr>
                    </table>
                    <?php
                        if($type_user == 1) {
                            if($p_namef=="") {
                            echo "<input type='submit' name='ins_con_father' value='Добавити'>";
                            }
                            else {
                            echo "<input type='submit' name='up_con_father' value='Оновити'>";
                            }
                        }
                    ?>
                    <br>
                        <?php
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
                                        echo "<input type='text' name='text_email_m' value='$p_emailm'>";
                                    }
                                    else {
                                        echo "<b>$p_emailm</b>";
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                        if($type_user == 1) {
                            if($p_namem=="") {
                                echo "<input type='submit' name='ins_con_mother' value='Добавити'>";
                            }
                            else {
                                echo "<input type='submit' name='up_con_mother' value='Оновити'>";
                            }
                        }
                    ?>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>