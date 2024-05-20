<?php
     session_start();
     $id_session = session_id(); 

      include('../failsite/config.php');

      include('db_to_docx_spusok_kody_navchannia.php');

      include('db_to_docx_spusok_report_vyboru.php');
     
      include('db_to_docx_spusok_report_vyboru_zahun.php');
      
      include('db_to_docx_spusok_dodatok.php');
      
      include('db_to_docx_perevirka_kvalif.php');

      include('translit.php');
  
//////////////////////////////////////////////////////

      if (isset($_GET["kateg"]))
      {
      	//////////////////////////////////////////////
      	 if ($_GET["kateg"]=="kody_navchannia")
      	 {
          //echo $_GET['f'];

          if(isset($_GET['f'])&&($_GET['f']<>''))
          {
            $sql_fakult="SELECT su_universityFacultetFullName FROM strukture_univ where su_id_UniversityFacultet=".$_GET['f'];
            $result_fakult=mysql_query($sql_fakult);
            list($u_universityFacultetFullName)=mysql_fetch_array($result_fakult);           
          }
          
           if ($_GET['r']==4) {$fakult="spzd_facultyName='".$u_universityFacultetFullName."' and ";} 
           else {$fakult="";}

            ////////////видалення файлів з фапки
            if (is_dir("PK_spysky/kodynavchannia/".$_GET['f'])) 
            { 
              if (file_exists("PK_spysky/kodynavchannia/".$_GET['f']))
                 foreach (glob("PK_spysky/kodynavchannia/".$_GET['f']."/*") as $file)
                  unlink($file);
            }
            //////////////видалення файлів з фапки

           $result_kn=
	         "SELECT DISTINCT spzd_id, spzd_isShortTerm, spzd_num_kurs, kft_kurs_for_edbo, spzd_facultyName, spzd_educationFormName            
	          FROM spets_zdobyv, kurs_for_tech
	          WHERE  ".$fakult." 
	               kft_kurs_for_edbo=spzd_el_id_kurs and kft_nomer_kursu<>1 and (spzd_isShortTerm=kft_baza_vstupu or kft_baza_vstupu='Б') order by spzd_id";

           //echo $result_kn."<br>";

   	       $resultb_kn=mysql_query($result_kn);
	       while($mas_kn=mysql_fetch_array($resultb_kn))
	       {
            //echo  "<br>".$mas_kn['spzd_id']." / ".$mas_kn['spzd_isShortTerm']." / ".$mas_kn['spzd_num_kurs']." / ".$mas_kn['kft_kurs_for_edbo']." / ".$_GET['f'];
	         	todoc_kod_navhannia($mas_kn['spzd_id'], $mas_kn['spzd_isShortTerm'], $mas_kn['spzd_num_kurs'], $mas_kn['kft_kurs_for_edbo'], $_GET['f']);
	       }    
           
           //////////////////////час оновлення
          $sql_dt="SELECT tbc_datatime FROM tb_const where tbc_tup='kody_navchannia' and tbc_ident_user='".$_SESSION['username']."'";
          $result_dt=mysql_query($sql_dt);
          if (mysql_affected_rows()==0)
          {
            //якщо немає запису вставимо
            $sql_dt_inst="insert into tb_const(tbc_tup, tbc_ident_user, tbc_datatime) values ('kody_navchannia', '".$_SESSION['username']."',NOW())";
            mysql_query($sql_dt_inst);          
          }
          elseif(mysql_affected_rows()==1)
          {          
            $sql_upd="UPDATE tb_const SET tbc_datatime=NOW() where tbc_tup='kody_navchannia' and tbc_ident_user='".$_SESSION['username']."'";
            mysql_query($sql_upd);
          }
          ///////////////////////////////час оновлення  


    	 }

    	//////////////////////////////////////////////////
      if ($_GET["kateg"]=="report_vyboru")
      {
              //активна група вибору
      ////////////////////////////////////////////////////////////
      $sql_ahv=
        "SELECT nhv_kod 
         FROM nazva_hrupa_vyboru
         WHERE nhv_dostypno=2";
         $resultb_ahv=mysql_query($sql_ahv);
         list($kod_active_gv)=mysql_fetch_array($resultb_ahv);
         ///////////////////////////////////////////////////////
         
          if(isset($_GET['f'])&&($_GET['f']<>''))
          {
            $sql_fakult="SELECT su_universityFacultetFullName FROM strukture_univ where su_id_UniversityFacultet=".$_GET['f'];
            $result_fakult=mysql_query($sql_fakult);
            list($u_universityFacultetFullName)=mysql_fetch_array($result_fakult);          
          }
          
           if ($_GET['r']==4) {$fakult="spzd_facultyName='".$u_universityFacultetFullName."' and ";} 
           else {$fakult="";}

         $result_kn=
           "SELECT DISTINCT spzd_id, spzd_isShortTerm, spzd_num_kurs, spzd_facultyName, spzd_educationFormName, spzd_el_id_kurs, qualificationGroupId            
            FROM spets_zdobyv, zdobuvachi
            WHERE ".$fakult." zdob_id_spest=spzd_id and educationId in (SELECT DIStinct vs_kod_navchanna_stud FROM perelik_subject_vubir_studenta WHERE vs_perevirka=1 and vs_nomer_osv_prog<>0 and vs_kod_zah_hrupy=".$kod_active_gv.")
                  order by spzd_facultyName, spzd_educationFormName";

                  
            ////////////видалення файлів з фапки
            if (is_dir("PK_spysky/report_vyboru/".$_GET['f'])) 
            { 
              if (file_exists("PK_spysky/report_vyboru/".$_GET['f']))
                 foreach (glob("PK_spysky/report_vyboru/".$_GET['f']."/*") as $file)
                  unlink($file);
            }
            //////////////видалення файлів з фапки


         $resultb_kn=mysql_query($result_kn);
         while($mas_kn=mysql_fetch_array($resultb_kn))
         {
           //echo $mas_kn['spzd_id']." ".$mas_kn['spzd_num_kurs']." ".$mas_kn['spzd_isShortTerm']."<br>";

           todoc_report_vyboru($mas_kn['spzd_id'], $mas_kn['spzd_isShortTerm'], $mas_kn['spzd_num_kurs'], $mas_kn['spzd_el_id_kurs'], $_GET['f'], $mas_kn['qualificationGroupId']);
         } 

           //////////////////////час оновлення
          $sql_dt="SELECT tbc_datatime FROM tb_const where tbc_tup='report_vyboru' and tbc_ident_user='".$_SESSION['username']."'";
          $result_dt=mysql_query($sql_dt);
          if (mysql_affected_rows()==0)
          {
            //якщо немає запису вставимо
            $sql_dt_inst="insert into tb_const(tbc_tup, tbc_ident_user, tbc_datatime) values ('report_vyboru', '".$_SESSION['username']."',NOW())";
            mysql_query($sql_dt_inst);          
          }
          elseif(mysql_affected_rows()==1)
          {          
            $sql_upd="UPDATE tb_const SET tbc_datatime=NOW() where tbc_tup='report_vyboru' and tbc_ident_user='".$_SESSION['username']."'";
            mysql_query($sql_upd);
          }
          ///////////////////////////////час оновлення  

                 
                
      }
      //////////////////////////////////////////////////
      if ($_GET["kateg"]=="report_vyboru_zah_un")
      {
        todoc_report_vyboru_zu($_GET['os'],2,"-");
      }
      ///////////////////////////////////////////////////
      if ($_GET["kateg"]=="dodatok")
      {
         todoc_dodatok($GLOBALS['id_kurt']);                     
      }

    }

?>