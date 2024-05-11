<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<form action="" method="post" enctype="multipart/form-data">
			<p>Загрузити документ</p>
			<input type="file" name="img_upload"><input type="submit" name="upload" value="Загрузити">
				<?php
					$id = 200;
					//$_GET['stud']
					if(!file_exists("photo/".$id)) 
					{
						mkdir("photo/".$id."");
					}
					$upload_file = "photo/".$id."/";
					if(isset($_POST['upload']))  
					{							
							$tmp_file = $_FILES['img_upload']['tmp_name'];
							move_uploaded_file($tmp_file, $upload_file."photo".$id.".jpeg");							
					} 
						/*
						else {
							$upload_file = "photo/".$id."";
							$tmp_file = $_FILES['img_upload']['tmp_name'];
							move_uploaded_file($tmp_file, $upload_file."photo".$id.".jpeg");
							echo "<img src='".$upload_file."photo".$id.".jpeg' alt=''>";
						}*/

						if(file_exists($upload_file."photo".$id.".jpeg"))
						{
							echo "<img src='".$upload_file."photo".$id.".jpeg'>";
						}
						else{
							echo "<img src='photo/siluet_man.png'>";
						}

					
				?>
		</form>
	</body>
</html>