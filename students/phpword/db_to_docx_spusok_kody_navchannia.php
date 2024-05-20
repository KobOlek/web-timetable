<?php

function todoc_kod_navhannia()
{
  require_once 'PHPWord.php';

    // New Word Document
  $PHPWord = new PHPWord();

  /// орієнтація сторінки        'orientation' => 'landscape',
    $sectionStyle = array( 
       'marginTop' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа сверху
       'marginLeft' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа слева
       'marginRight' => '570', // по-умолчанию равен 1418* и соответствует 2,5 см отступа справа
       'marginBottom' => '570'); // по-умолчанию равен 1134* и соответствует 2 см отступа снизу

   // New portrait section
  
  $PHPWord->addParagraphStyle('pStyle', array('align' => 'left', 'spaceAfter' => 0));

  $section = $PHPWord->createSection($sectionStyle);

   $facultyName=""; $qualificationGroupName=""; $baseQualificationName=""; $fullSpecialityName=""; $specializationName=""; $studyProgramName=""; $educationFormName=""; $educationDateEnd="";

  $sql_kn=
  "SELECT distinct facultyName, qualificationGroupName, baseQualificationName, fullSpecialityName, specializationName, studyProgramName, educationFormName, educationDateEnd              
      FROM zdobuvachi
      WHERE zdob_id_spest=".$spzd_id;
   $resultb_kn=mysql_query($sql_kn);
if (mysql_affected_rows()<>0)
{
     
   list($facultyName, $qualificationGroupName, $baseQualificationName, $fullSpecialityName, $specializationName, $studyProgramName, $educationFormName, $educationDateEnd)=mysql_fetch_array($resultb_kn);

  $section->addText('Переклад дисциплін', array('name'=>'Times New Roman','bold'=>true,'size'=>12,'align'=>'center'));

  // Define table style arrays
 
  $styleTable = array('borderSize'=>6, 'borderColor'=>'000000'); //,'cellMargin'=>50
  $styleFirstRow = array('borderBottomSize'=>1, 'borderBottomColor'=>'0000FF');
  // Define cell style arrays
  $styleCell = array('valign'=>'center');
  $styleCellBTLR = array('valign'=>'center'); //,'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR
  // Define font style for first row
  $fontStyle = array('bold'=>true, 'align'=>'center','name'=>'Times New Roman','size'=>12);
  // Add table style
  $PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
  // Add table
  $table = $section->addTable('myOwnTableStyle');

  //echo "0000-".$id_sp;
  $fontStylemy2 = array('name'=>'Times New Roman','size'=>11);
  $fontStylemy = array('name'=>'Times New Roman','size'=>9);
 //echo "<br>".$spzd_id." <br> ";
 $sql_z="SELECT personName, personId
           FROM zdobuvachi
           WHERE zdob_id_spest=".$spzd_id."               
           order by personName";  

  //echo  $sql_z."<br>";
  // Add row  
  $table->addRow();
  // Add cells
  $table->addCell(8000,$styleCell)->addText('Дисципліни', $fontStyle,'pStyle');
  $table->addCell(1000,$styleCell)->addText("Кредит", $fontStyle,'pStyle');
  $table->addCell(1000,$styleCell)->addText("Бал", $fontStyle,'pStyle');
  
/////////////////////////////////////////////////////////////////////////////   

    $result_z=mysql_query($sql_z);
    $i=1;
    if(mysql_affected_rows()>0)
    {
      while($mas_z=mysql_fetch_array($result_z))
      { 
       $table->addRow();
       $table->addCell(8000,$styleCell)->addText("$i.",$fontStylemy,'pStyle');
       $table->addCell(1000,$styleCell)->addText($mas_z['personName'],$fontStylemy2,'pStyle'); 
       $table->addCell(1000,$styleCell)->addText($mas_z['personId'],$fontStylemy2,'pStyle');       
       //////////////////
       $i++;
      }
    }
  //Save File
  if($qualificationGroupName=="Бакалавр"){$qualificationGroupName="Б";}
  elseif($qualificationGroupName=="Магістр"){$qualificationGroupName="М";}

  $text3 ="dycstupl_ua_en_".date();

  $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

  $objWriter->save("PK_spysky/kodynavchannia/".$text3);

  $wliah=$GLOBALS['site']."PK_spysky/kodynavchannia/".$text3;
  
  //echo "<br>".$text3_." ".$spzd_id." - Сформовано!!!!";

  echo "<br>Завантажити: <a href='".$wliah."'>".$text3."</a>";

}  

///////////////////////////////////////////////////////////////////////////
}