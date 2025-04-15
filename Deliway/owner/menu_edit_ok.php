<?php
session_start();
include "../config/db.php"; 

$menu_idx = $_POST['menu_idx'];
$menu_category = $_POST['menu_category'];
$store_menu_name = $_POST['store_menu_name'];
$store_menu_cost = $_POST['store_menu_cost'];
$store_menu_memo = $_POST['store_menu_memo'];

$files = $_FILES["upfile"];

	$count = count($files["name"]);
		
	$upload_dir = '../code/upload/';

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
				($upfile_type[$i] != "image/jpg") &&
				($upfile_type[$i] != "image/png"))
            
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

		$sql = "select * from menu where menu_idx='".$menu_idx."'";   // get target record
		
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
				
				$delete_path = "../code/upload/".$delete_name;

				unlink($delete_path);

				$sql = "update menu set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value', menu_category='".$menu_category."', store_menu_name='".$store_menu_name."', store_menu_cost='".$store_menu_cost."', store_menu_memo='".$store_menu_memo."' where menu_idx=".$menu_idx."";
				echo $sql;
				mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
				
				
			}
			else
			{
				if (!$upfile_error[$i])
				{
					$sql = "update menu set $field_org_name = '$org_name_value', $field_real_name = '$org_real_value', menu_category='".$menu_category."', store_menu_name='".$store_menu_name."', store_menu_cost='".$store_menu_cost."', store_menu_memo='".$store_menu_memo."' where menu_idx=".$menu_idx."";
					
					
					mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행		
					
				}
			}

		}
		$sql = "update menu set menu_category='".$menu_category."', store_menu_name='".$store_menu_name."', store_menu_cost='".$store_menu_cost."', store_menu_memo='".$store_menu_memo."' where menu_idx=".$menu_idx."";
		
		
		
		mysqli_query($con,$sql);  // $sql 에 저장된 명령 실행
		
	
}
?>

<script>
    alert("메뉴 정보를 수정하였습니다.");
    location.href="owner_menu.html";
</script>