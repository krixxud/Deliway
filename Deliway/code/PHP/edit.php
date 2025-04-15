<?php

$files = $_FILES["upfile"];

	$count = count($files["name"]);
		
	$upload_dir = 'upload/';

	for ($i=0; $i<$count; $i++)
	{
		$upfile_name[$i]     = $files["name"][$i];
		
		$upfile_tmp_name[$i] = $files["tmp_name"][$i];
		$upfile_type[$i]     = $files["type"][$i];
		$upfile_size[$i]     = $files["size"][$i];
		$upfile_error[$i]    = $files["error"][$i];
        
		$file = explode(".", $upfile_name[$i]);
		
		
		$file_name = $file[0];
		$file_ext  = $file[1];

		if (!$upfile_error[$i])
		{
			$new_file_name = date("Y_m_d_H_i_s");
			$new_file_name = $new_file_name."_".$i;
			$copied_file_name[$i] = $new_file_name.".".$file_ext;      
			$uploaded_file[$i] = $upload_dir.$copied_file_name[$i];

			if( $upfile_size[$i]  > 51200000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
			}

			if ( ($upfile_type[$i] != "image/gif") &&
				($upfile_type[$i] != "image/jpeg") &&
				($upfile_type[$i] != "image/png") &&
				($upfile_type[$i] != "application/pdf") &&
				($upfile_type[$i] != "application/hwp") &&
				($upfile_type[$i] != "application/gpx") &&
				($upfile_type[$i] != "image/pjpeg") )
			{
				echo("
					<script>
						alert('JPG와 GIF와 PNG 이미지 파일만 업로드 가능합니다!');
						history.go(-1)
					</script>
					");
				exit;
			}

			if (!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]) )
			{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
			}
		}
	}

if ($mode==$_POST["modify"])
{
	$num_checked = count($_POST['del_file']);
	
		$position = $_POST['del_file'];

		for($i=0; $i<$num_checked; $i++)                      // delete checked item
		{
			$index = $position[$i];
			$del_ok[$index] = "y";
		}

		$sql = "select * from 테이블명 where idx='".$idx."'";   // get target record
		
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);

		for ($i=0; $i<$count; $i++)					// update DB with the value of file input box
		{

			$field_org_name = "file_name_".$i;
			
			$field_real_name = "file_copied_".$i;
			

			$org_name_value = $upfile_name[$i];
			

			$org_real_value = $copied_file_name[$i];
			

			if ($del_ok[$i] == "y")
			{
				$delete_field = "file_copied_".$i;
				$delete_name = $row[$delete_field];
				
				$delete_path = "upload/".$delete_name;

				unlink($delete_path);

				$sql = "update 테이블명 set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value', 필드명='".$변수명."' where idx=".$idx."";
				echo $sql;
				mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
				
				
			}
			else
			{
				if (!$upfile_error[$i])
				{
					$sql = "update 테이블명 set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value', 필드명='".$변수명."' where idx=".$idx."";
					
					
					mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행		
					
				}
			}

		}
		$sql = "update 테이블명 set 필드명='".$변수명."' where _idx=".$_idx."";
		
		
		
		mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
		
	
}
?>