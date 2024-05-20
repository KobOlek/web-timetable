<?php
    set_include_path(implode(PATH_SEPARATOR,array(realpath(__DIR__.'/Classes'), get_include_path())));

     ////////////////////////////////////////////////////////////////////////////////////////////////////
     include("config.php");
    
     require_once 'phpword/PHPWord.php';
    $structure = $_SERVER['DOCUMENT_ROOT']."/denys/doc";
  
    $PHPWord = new PHPWord();

    /// орієнтація сторінки
      $sectionStyle = array( 
         'orientation' => 'landscape', 
         'marginTop' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа сверху
         'marginLeft' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа слева
         'marginRight' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа справа
         'marginBottom' => '570'); // по-умолчанию равен 1134* и соответствует 2 см отступа снизу
    
    $PHPWord->addParagraphStyle('pStyle', array('align' => 'left', 'spaceAfter' => 0));
  
    $section = $PHPWord->createSection($sectionStyle);
  
    $section->addText('Розклад', array('name'=>'Times New Roman','bold'=>true,'size'=>15,'align'=>'center'));
  
    // Define table style arrays
    
    $styleTable = array('borderSize'=>6, 'borderColor'=>'000000'); //,'cellMargin'=>50
    // Define cell style arrays
    $styleCell = array('valign'=>'center');
    // Define font style for first row
    $fontStyle = array('bold'=>true, 'align'=>'center','name'=>'Times New Roman','size'=>12);
    // Add table style
    $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
    // Add table
    $table = $section->addTable('myOwnTableStyle');
  
    $fontStylemy = array('name'=>'Times New Roman','size'=>9);
  
    $table->addRow();
    // Add cells
    $table->addCell(8000,$styleCell)->addText('Клас', $fontStyle,'pStyle');

  
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  /*
     $sql_fakult_formaNavch="SELECT db_id, db_text_ua, db_text_en,db_coment FROM stud WHERE st_cl_id=3";
     $resultb_fakult_formaNavch=mysqli_query($GLOBALS['link'],$sql_fakult_formaNavch);           
     if(mysqli_affected_rows($GLOBALS['link'])>0)  
      {
        while($mas_result=mysqli_fetch_array($resultb_fakult_formaNavch))
        { 
          $table->addRow();
          $table->addCell(8000,$styleCell)->addText($mas_result['db_text_ua'],$fontStylemy,'pStyle');// № п/п
          $table->addCell(8000,$styleCell)->addText($mas_result['db_text_en'],$fontStylemy,'pStyle');// № п/п
          $table->addCell(2000,$styleCell)->addText($mas_result['db_coment'],$fontStylemy,'pStyle'); 
       }            
      }
      */
  //////////////////////////////////////////////////////////////////////////////////
   // Save File  $GLOBALS["part_to_file"].
    $text3="rozk".Date("Y_m_d-H_i_s_ms").".docx";
    $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
    $objWriter->save($structure."/".$text3);
    $wliah="/denys/doc/".$text3;
    echo "<br><p>Завантажити: <a href='".$wliah."'>".$text3."</a></p>";  
  
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if(isset($_POST['but_image']))
    {
       $errors= array();
       
       $file_name = $_FILES['image']['name'];
       $file_tmp =  $_FILES['image']['tmp_name'];
       $file_type = $_FILES['image']['type'];
     
       $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

       $expensions= array("xls","xlsx");

       $uploadfile= "uploadfile/".$file_name;
       $uploadfile_imp_prn= "uploadfile/".$file_name;

       if(in_array($file_ext,$expensions) === false)
       {
          $errors[]="extension not allowed, please choose a xls or xlsx file.";
       }

      if (empty($errors)==true)
      {
        if($file_ext=='xlsx'){$tf=1;}else{$tf=2;}
          //echo $uploadfile;
          move_uploaded_file($file_tmp,$uploadfile);
          echo "Success<br>";
          //echo $_POST['select_company'];
          import_prn($uploadfile_imp_prn);
          
          unlink($uploadfile);
       }
       else
       {
          print_r($errors); 
       }      
    }  
        echo "<form action = '' method = 'POST' enctype = 'multipart/form-data'>
                <input type = 'file' name='image'/>
                <input type = 'submit' name='but_image'/>
                </form>";
              
function import_prn($uploadf)
{
      include("config.php");

	    require_once 'PHPExcel.php'; //подключаем наш фреймворк

        /** PHPExcel_IOFactory */
	    include 'PHPExcel/IOFactory.php';
	  
	    // $ar=array(); // инициализируем массив
	    //$inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
	    $objReader = PHPExcel_IOFactory::createReader('Excel2007'); // создаем объект для чтения файла      Excel5
       
       $objReader->setReadDataOnly(true);


	    $objPHPExcel = $objReader->load($uploadf); // загружаем данные файла в объект

	    $sheet = $objPHPExcel->getSheet(0);
	    
	    $ii=0; $max_zvo_idvnz=0;
	    for ($i = 2; $i<=$sheet->getHighestRow(); $i++) //-1434   
	    {
            $st_cl_id = $sheet->getCellByColumnAndRow(0, $i)->getValue();
            $st_pib = $sheet->getCellByColumnAndRow(1, $i)->getValue();
            $st_birsday = $sheet->getCellByColumnAndRow(2, $i)->getValue();
            $st_stat = $sheet->getCellByColumnAndRow(3, $i)->getValue();
            $st_status = $sheet->getCellByColumnAndRow(4, $i)->getValue();			
	      
              $table_colump="st_cl_id,st_pib,st_birsday,st_stat,st_status";
       
              $insert_values=
               $st_cl_id.",'".
               str_replace("’","`",str_replace("'","`",$st_pib))."','".
               $st_birsday."','".
               $st_stat."','".
               $st_status."'"; 

               $prn="INSERT INTO stud(".$table_colump.") VALUES (".$insert_values.")";
               echo $prn.";<br>";
               $into = $conn->query($prn);
              
               $ii++;
			}
  }

?>